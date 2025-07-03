const { createApp } = Vue

const apiUrl = 'https://setiawanarticle.my.id' // CodeIgniter 4 API

createApp({
  data() {
    return {
      artikel: [],
      kategori: [],
      formData: {
        id: null,
        judul: '',
        isi: '',
        status: 0,
        id_kategori: '',
        gambar: null
      },
      selectedFile: null,
      imagePreview: null,
      isUploading: false,
      showForm: false,
      formTitle: 'Tambah Data',
      statusOptions: [
        { text: 'Draft', value: 0 },
        { text: 'Publish', value: 1 }
      ]
    }
  },
  mounted() {
    this.loadData()
    this.loadKategori()
  },
  methods: {
    loadData() {
      axios.get(apiUrl + '/post')
        .then(res => {
          console.log('API Response:', res.data)
          this.artikel = res.data.artikel || []
        })
        .catch(err => {
          console.error('Error loading data:', err)
          alert('Error loading data: ' + (err.response?.data?.message || err.message))
        })
    },
    loadKategori() {
      axios.get(apiUrl + '/kategori')
        .then(res => {
          console.log('Kategori Response:', res.data)
          this.kategori = res.data.kategori || []
        })
        .catch(err => {
          console.error('Error loading kategori:', err)
          // Set default kategori jika gagal load
          this.kategori = []
        })
    },
    tambah() {
      this.showForm = true
      this.formTitle = 'Tambah Data'
      this.formData = { id: null, judul: '', isi: '', status: 0, id_kategori: '', gambar: null }
      this.selectedFile = null
      this.imagePreview = null
    },
    edit(row) {
      this.showForm = true
      this.formTitle = 'Ubah Data'
      this.formData = { ...row }
      this.selectedFile = null
      this.imagePreview = null
    },
    hapus(index, id) {
      if (confirm('Yakin ingin menghapus data ini?')) {
        axios.delete(apiUrl + '/post/' + id)
          .then(() => {
            this.artikel.splice(index, 1)
            alert('Data berhasil dihapus')
          })
          .catch(err => {
            console.error('Error deleting data:', err)
            alert('Error deleting data: ' + (err.response?.data?.message || err.message))
          })
      }
    },
    saveData() {
      this.isUploading = true

      const url = this.formData.id
        ? apiUrl + '/post/' + this.formData.id
        : apiUrl + '/post'

      // Create FormData for file upload
      const formData = new FormData()
      formData.append('judul', this.formData.judul)
      formData.append('isi', this.formData.isi)
      formData.append('status', this.formData.status)
      formData.append('id_kategori', this.formData.id_kategori)

      // For edit, add _method=PUT to simulate PUT request via POST
      if (this.formData.id) {
        formData.append('_method', 'PUT')
      }

      if (this.selectedFile) {
        formData.append('gambar', this.selectedFile)
      }

      // Use appropriate HTTP method - always POST for multipart/form-data
      const config = {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }

      axios.post(url, formData, config)
        .then((response) => {
          console.log('Save response:', response.data)
          this.loadData()
          this.closeModal()
          alert('Data berhasil disimpan')
        })
        .catch(err => {
          console.error('Error saving data:', err)
          alert('Error saving data: ' + (err.response?.data?.message || err.message))
        })
        .finally(() => {
          this.isUploading = false
        })
    },
    statusText(status) {
      return status == 1 ? 'Publish' : 'Draft'
    },
    getNamaKategori(id_kategori) {
      if (!id_kategori) return '-'
      const kategori = this.kategori.find(k => k.id_kategori == id_kategori)
      return kategori ? kategori.nama_kategori : '-'
    },
    formatIsi(isi, isPreview = true) {
      if (!isi) return ''
      let formatted = isi

      // Limit preview length (like CI4 backend)
      if (isPreview && formatted.length > 200) {
        formatted = formatted.substring(0, 200) + '...'
      }

      // Escape HTML first for security
      formatted = formatted.replace(/&/g, '&amp;')
                          .replace(/</g, '&lt;')
                          .replace(/>/g, '&gt;')
                          .replace(/"/g, '&quot;')
                          .replace(/'/g, '&#39;')

      // Apply formatting in specific order to avoid conflicts
      // Use temporary placeholders to avoid conflicts

      // Headings: ### text -> <h3>text</h3>
      formatted = formatted.replace(/^### (.+)$/gm, '___H3_START___$1___H3_END___')

      // Lists: - item -> <li>item</li>
      formatted = formatted.replace(/^- (.+)$/gm, '___LI_START___$1___LI_END___')

      // Horizontal rule: --- -> <hr>
      formatted = formatted.replace(/^---$/gm, '___HR___')

      // Replace placeholders with actual HTML tags
      formatted = formatted.replace(/___H3_START___/g, '<h3>')
                          .replace(/___H3_END___/g, '</h3>')
                          .replace(/___LI_START___/g, '<li>')
                          .replace(/___LI_END___/g, '</li>')
                          .replace(/___HR___/g, '<hr>')

      // Wrap consecutive <li> elements in <ul>
      formatted = formatted.replace(/(<li>.*?<\/li>)(\s*<li>.*?<\/li>)*/g, function(match) {
        return '<ul>' + match + '</ul>'
      })

      // Convert line breaks to <br> (but not inside lists or headings)
      formatted = formatted.replace(/\n(?!<\/?(ul|li|h3))/g, '<br>')

      // Clean up extra <br> tags around block elements
      formatted = formatted.replace(/<br>\s*(<\/?(?:h3|ul|li|hr))/g, '$1')
      formatted = formatted.replace(/(<\/?(?:h3|ul|li|hr)[^>]*>)\s*<br>/g, '$1')

      return formatted
    },
    closeModal() {
      this.showForm = false
      this.formData = { id: null, judul: '', isi: '', status: 0, id_kategori: '', gambar: null }
      this.selectedFile = null
      this.imagePreview = null
      this.isUploading = false
      // Reset file input
      if (this.$refs.fileInput) {
        this.$refs.fileInput.value = ''
      }
    },
    handleFileUpload(event) {
      const file = event.target.files[0]
      if (file) {
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif']
        if (!allowedTypes.includes(file.type)) {
          alert('File harus berupa gambar (JPEG, PNG, GIF)')
          event.target.value = ''
          return
        }

        // Validate file size (2MB)
        if (file.size > 2048000) {
          alert('Ukuran file maksimal 2MB')
          event.target.value = ''
          return
        }

        this.selectedFile = file

        // Create preview
        const reader = new FileReader()
        reader.onload = (e) => {
          this.imagePreview = e.target.result
        }
        reader.readAsDataURL(file)
      }
    },
    removeImage() {
      this.selectedFile = null
      this.imagePreview = null
      if (this.$refs.fileInput) {
        this.$refs.fileInput.value = ''
      }
    },

    removeExistingImage() {
      this.formData.gambar = null
    },
    removeExistingImage() {
      this.formData.gambar = null
    },

    // Rich Text Editor Methods
    insertFormat(startTag, endTag) {
      const textarea = this.$refs.editorTextarea
      if (!textarea) return

      const start = textarea.selectionStart
      const end = textarea.selectionEnd
      const selectedText = textarea.value.substring(start, end)

      let newText
      if (selectedText) {
        // If text is selected, wrap it
        newText = startTag + selectedText + endTag
      } else {
        // If no selection, insert placeholder
        const placeholder = this.getPlaceholderText(startTag)
        newText = startTag + placeholder + endTag
      }

      // Replace selected text or insert at cursor
      const beforeText = textarea.value.substring(0, start)
      const afterText = textarea.value.substring(end)

      this.formData.isi = beforeText + newText + afterText

      // Focus back to textarea

      // Set cursor position
      this.$nextTick(() => {
        const newCursorPos = start + newText.length
        textarea.focus()
        textarea.setSelectionRange(newCursorPos, newCursorPos)
      })
    },

    getPlaceholderText(startTag) {
      const placeholders = {
        '\n\n### ': 'Judul Bagian',
        '\n- ': 'Item list',
        '\n\n---\n\n': ''
      }
      return placeholders[startTag] || 'teks'
    }
  }
}).mount('#app')
