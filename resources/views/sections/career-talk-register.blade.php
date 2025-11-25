@extends('layouts.app')

@section('title', 'Registrasi Career Talk - Inception 2026')

@section('content')
<section class="register-section">
    <div class="blur-circle"></div>
    <div class="blur-circle"></div>
    <div class="blur-circle"></div>
    
    <div class="container-custom">
        <div class="register-wrapper">
            <!-- Left Side - Info -->
            <div class="register-info">
                <div class="info-header">
                    <a href="{{ route('career-talk') }}" class="back-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        Kembali
                    </a>
                    <h1>Daftar Career Talk</h1>
                    <p>Lengkapi formulir di samping untuk mendaftar</p>
                </div>

                <div class="event-details">
                    <h3>Detail Acara</h3>
                    <div class="detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <div>
                            <strong>Tanggal</strong>
                            <p>30 November 2026</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <div>
                            <strong>Waktu</strong>
                            <p>09:00 - 13:00 WIB</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <div>
                            <strong>Lokasi</strong>
                            <p>Zoom Meeting</p>
                        </div>
                    </div>
                </div>

                <div class="benefits-list">
                    <h3>Yang Akan Kamu Dapatkan</h3>
                    <ul>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            E-Certificate
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Networking Session
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Exclusive Materials
                        </li>

                    </ul>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="register-form-wrapper">
                <form action="{{ route('career-talk.register.store') }}" method="POST" enctype="multipart/form-data" class="register-form">
                    @csrf
                    
                    @if($errors->any())
                    <div class="alert alert-error">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        <div>
                            <strong>Oops! Ada kesalahan:</strong>
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <div class="form-section">
                        <h3>Data Pribadi</h3>
                        
                        <div class="form-group">
                            <label for="full_name">Nama Lengkap <span class="required">*</span></label>
                            <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required placeholder="Masukkan nama lengkap">
                            @error('full_name')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email <span class="required">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com">
                                @error('email')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone">No. WhatsApp <span class="required">*</span></label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx">
                                @error('phone')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Data Akademik</h3>
                        
                        <div class="form-group">
                            <label for="institution">Asal Institusi <span class="required">*</span></label>
                            <input type="text" id="institution" name="institution" value="{{ old('institution') }}" required placeholder="Universitas/Sekolah">
                            @error('institution')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="major">Program Studi <span class="required">*</span></label>
                                <input type="text" id="major" name="major" value="{{ old('major') }}" required placeholder="Teknik Perminyakan">
                                @error('major')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="semester">Semester <span class="required">*</span></label>
                                <select id="semester" name="semester" required>
                                    <option value="">Pilih Semester</option>
                                    @for($i = 1; $i <= 14; $i++)
                                    <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                    @endfor
                                </select>
                                @error('semester')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Motivasi</h3>
                        
                        <div class="form-group">
                            <label for="motivation">Kenapa Kamu Ingin Mengikuti Career Talk Ini? <span class="required">*</span></label>
                            <textarea id="motivation" name="motivation" rows="5" required placeholder="Ceritakan motivasimu mengikuti acara ini...">{{ old('motivation') }}</textarea>
                            <span class="char-count">
                                <span id="charCount">0</span>/1000 karakter
                            </span>
                            @error('motivation')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-section payment-section">
                        <h3>Pembayaran</h3>
                        
                        <div class="payment-info-box">
                            <div class="payment-header">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                <h4>Biaya Pendaftaran</h4>
                            </div>
                            
                            <div class="payment-amount">
                                <span class="amount-label">Total Pembayaran:</span>
                                <span class="amount-value">Rp 10.000</span>
                            </div>

                            <div class="bank-details">
                                <div class="bank-info">
                                    <div class="bank-logo">BCA</div>
                                    <div class="bank-account">
                                        <strong>No. Rekening</strong>
                                        <div class="account-number">
                                            <span id="accountNumber">7311086417</span>
                                            <button type="button" class="copy-button" onclick="copyAccountNumber()">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                                <span class="copy-text">Salin</span>
                                            </button>
                                        </div>
                                        <p class="account-name">a/n <strong>Dega Arsyan Widhya</strong></p>
                                    </div>
                                </div>
                            </div>

                            <div class="payment-steps">
                                <p class="steps-title">Cara Pembayaran:</p>
                                <ol>
                                    <li>Transfer sejumlah <strong>Rp 10.000</strong> ke rekening di atas</li>
                                    <li>Simpan bukti transfer (screenshot)</li>
                                    <li>Upload bukti transfer pada form di bawah</li>
                                </ol>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="payment_proof">Upload Bukti Pembayaran <span class="required">*</span></label>
                            <div class="file-upload-wrapper">
                                <input type="file" id="payment_proof" name="payment_proof" accept="image/*,.pdf" required class="file-input">
                                <label for="payment_proof" class="file-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                    <span class="file-label-text">Pilih File atau Drop di sini</span>
                                    <span class="file-label-hint">Format: JPG, PNG, PDF (Max 2MB)</span>
                                </label>
                                <div class="file-preview" id="filePreview"></div>
                            </div>
                            @error('payment_proof')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="submit-button">
                            Kirim Pendaftaran
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    // Character counter
    const textarea = document.getElementById('motivation');
    const charCount = document.getElementById('charCount');
    
    if (textarea && charCount) {
        textarea.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count;
            
            if (count > 1000) {
                charCount.style.color = 'var(--color-red)';
            } else {
                charCount.style.color = 'inherit';
            }
        });
        
        // Initialize count
        charCount.textContent = textarea.value.length;
    }

    // File upload handling
    const fileInput = document.getElementById('payment_proof');
    const filePreview = document.getElementById('filePreview');
    const fileLabel = document.querySelector('.file-label');

    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            handleFileSelect(e.target.files[0]);
        });

        // Drag and drop
        fileLabel.addEventListener('dragover', function(e) {
            e.preventDefault();
            fileLabel.classList.add('drag-over');
        });

        fileLabel.addEventListener('dragleave', function() {
            fileLabel.classList.remove('drag-over');
        });

        fileLabel.addEventListener('drop', function(e) {
            e.preventDefault();
            fileLabel.classList.remove('drag-over');
            
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                handleFileSelect(e.dataTransfer.files[0]);
            }
        });
    }

    function handleFileSelect(file) {
        if (!file) return;

        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB!');
            fileInput.value = '';
            return;
        }

        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
        if (!validTypes.includes(file.type)) {
            alert('Format file harus JPG, PNG, atau PDF!');
            fileInput.value = '';
            return;
        }

        // Show preview
        filePreview.innerHTML = '';
        
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                filePreview.innerHTML = `
                    <div class="preview-container">
                        <img src="${e.target.result}" alt="Preview">
                        <div class="preview-info">
                            <p class="preview-name">${file.name}</p>
                            <p class="preview-size">${(file.size / 1024).toFixed(2)} KB</p>
                            <button type="button" class="remove-file" onclick="removeFile()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        } else if (file.type === 'application/pdf') {
            filePreview.innerHTML = `
                <div class="preview-container pdf">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    <div class="preview-info">
                        <p class="preview-name">${file.name}</p>
                        <p class="preview-size">${(file.size / 1024).toFixed(2)} KB</p>
                        <button type="button" class="remove-file" onclick="removeFile()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            Hapus
                        </button>
                    </div>
                </div>
            `;
        }

        filePreview.style.display = 'block';
    }

    function removeFile() {
        fileInput.value = '';
        filePreview.innerHTML = '';
        filePreview.style.display = 'none';
    }

    // Copy account number
    function copyAccountNumber() {
        const accountNumber = document.getElementById('accountNumber').textContent;
        const copyButton = document.querySelector('.copy-button');
        const copyText = copyButton.querySelector('.copy-text');
        
        navigator.clipboard.writeText(accountNumber).then(function() {
            copyText.textContent = 'Tersalin!';
            copyButton.classList.add('copied');
            
            setTimeout(function() {
                copyText.textContent = 'Salin';
                copyButton.classList.remove('copied');
            }, 2000);
        }).catch(function() {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = accountNumber;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            
            copyText.textContent = 'Tersalin!';
            setTimeout(function() {
                copyText.textContent = 'Salin';
            }, 2000);
        });
    }
</script>
@endsection