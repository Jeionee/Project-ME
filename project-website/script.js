// JavaScript untuk halaman Modul Pembelajaran
document.addEventListener('DOMContentLoaded', function() {
    // Data kursus dummy untuk simulasi
    const coursesData = [
        {
            id: 1,
            title: "Pengenalan Dasar Negara",
            description: "Mempelajari pengertian negara, syarat terbentuknya negara, dan bentuk-bentuk negara",
            level: "Pemula",
            chapters: 5,
            progress: 0,
            lessons: [
                {
                    title: "Pengertian dan Konsep Dasar Negara",
                    duration: "20 menit",
                    content: "Negara adalah organisasi politik dari kekuasaan politik atau wilayah yang berpenduduk dan berdaulat. Pada konteks ini akan dibahas syarat-syarat terbentuknya sebuah negara dan elemen-elemen dasarnya.",
                    type: "video"
                },
                {
                    title: "Syarat Terbentuknya Negara",
                    duration: "25 menit",
                    content: "Terdapat beberapa syarat untuk terbentuknya sebuah negara, yaitu adanya wilayah, penduduk tetap, pemerintahan, dan pengakuan dari negara lain.",
                    type: "text"
                },
                {
                    title: "Bentuk-Bentuk Negara",
                    duration: "30 menit",
                    content: "Bentuk negara dapat dibedakan menjadi negara kesatuan dan negara federal. Masing-masing memiliki karakteristik tersendiri dalam pembagian kekuasaan pemerintahannya.",
                    type: "interactive"
                },
                {
                    title: "Teori Asal Mula Negara",
                    duration: "25 menit",
                    content: "Ada berbagai teori tentang asal mula negara, termasuk teori ketuhanan, teori kekuatan, teori kontrak sosial, dan teori organis.",
                    type: "video"
                },
                {
                    title: "Kuis: Dasar-Dasar Negara",
                    duration: "15 menit",
                    content: "Evaluasi pemahaman Anda tentang konsep dasar kenegaraan melalui serangkaian pertanyaan interaktif.",
                    type: "quiz"
                }
            ]
        },
        {
            id: 2,
            title: "Sistem Pemerintahan",
            description: "Mempelajari berbagai sistem pemerintahan seperti demokrasi, presidensial, parlementer, dan lainnya",
            level: "Menengah",
            chapters: 7,
            progress: 0,
            lessons: [
                {
                    title: "Pengenalan Sistem Pemerintahan",
                    duration: "20 menit",
                    content: "Sistem pemerintahan adalah sistem yang menjalankan wewenang dan kekuasaan dalam mengatur kehidupan sosial, ekonomi, dan politik suatu negara.",
                    type: "video"
                },
                {
                    title: "Sistem Demokrasi",
                    duration: "30 menit",
                    content: "Demokrasi adalah bentuk pemerintahan di mana kekuasaan tertinggi berada di tangan rakyat dan dijalankan langsung oleh mereka atau wakil-wakil yang dipilih.",
                    type: "interactive"
                },
                {
                    title: "Sistem Presidensial",
                    duration: "25 menit",
                    content: "Sistem presidensial adalah sistem pemerintahan di mana presiden menjabat sebagai kepala negara sekaligus kepala pemerintahan.",
                    type: "text"
                }
            ]
        },
        {
            id: 3,
            title: "Konstitusi dan Hukum Dasar",
            description: "Mempelajari pengertian, fungsi, dan implementasi konstitusi dalam kehidupan bernegara",
            level: "Menengah",
            chapters: 6,
            progress: 0,
            lessons: [
                {
                    title: "Pengertian Konstitusi",
                    duration: "15 menit",
                    content: "Konstitusi adalah hukum dasar yang menjadi pegangan dalam penyelenggaraan suatu negara.",
                    type: "video"
                },
                {
                    title: "Fungsi dan Tujuan Konstitusi",
                    duration: "25 menit",
                    content: "Konstitusi berfungsi sebagai pembatas kekuasaan pemerintah, perlindungan hak asasi warga negara, dan dasar organisasi negara.",
                    type: "text"
                }
            ]
        }
    ];

    // Fungsi untuk membuat elemen modul kursus
    function renderCourses() {
        const courseContainer = document.getElementById('course-list');
        if (!courseContainer) return;
        
        courseContainer.innerHTML = '';
        
        coursesData.forEach(course => {
            const courseElement = document.createElement('div');
            courseElement.className = 'course-card';
            courseElement.innerHTML = `
                <div class="course-image" style="background-image: url('https://via.placeholder.com/300x200');"></div>
                <div class="course-content">
                    <h3>${course.title}</h3>
                    <p>${course.description}</p>
                    <div class="progress-bar">
                        <div class="progress" style="width: ${course.progress}%"></div>
                    </div>
                    <div class="course-meta">
                        <span>${course.chapters} Bab</span>
                        <span>${course.level}</span>
                    </div>
                    <button class="btn course-btn" data-id="${course.id}">Mulai Belajar</button>
                </div>
            `;
            courseContainer.appendChild(courseElement);
        });
        
        // Tambahkan event listener untuk tombol kursus
        document.querySelectorAll('.course-btn').forEach(button => {
            button.addEventListener('click', function() {
                const courseId = this.getAttribute('data-id');
                openCourse(courseId);
            });
        });
    }
    
    // Fungsi untuk membuka halaman detail kursus
    function openCourse(courseId) {
        const course = coursesData.find(c => c.id == courseId);
        if (!course) return;
        
        // Simpan ID kursus saat ini ke localStorage
        localStorage.setItem('currentCourseId', courseId);
        
        // Redirect ke halaman kursus (dalam contoh ini, kita akan menampilkan modal)
        showCourseModal(course);
    }
    
    // Fungsi untuk menampilkan modal detail kursus
    function showCourseModal(course) {
        // Cek apakah modal sudah ada
        let courseModal = document.getElementById('course-detail-modal');
        
        // Jika belum ada, buat modal baru
        if (!courseModal) {
            courseModal = document.createElement('div');
            courseModal.id = 'course-detail-modal';
            courseModal.className = 'modal';
            document.body.appendChild(courseModal);
        }
        
        // Generate konten modal
        courseModal.innerHTML = `
            <div class="modal-content course-modal-content">
                <span class="close-btn" id="close-course-modal">&times;</span>
                <h2>${course.title}</h2>
                <p>${course.description}</p>
                <div class="course-info">
                    <div class="info-item">
                        <strong>Level:</strong> ${course.level}
                    </div>
                    <div class="info-item">
                        <strong>Jumlah Bab:</strong> ${course.chapters}
                    </div>
                </div>
                <h3>Daftar Materi</h3>
                <div class="lesson-list">
                    ${course.lessons.map((lesson, index) => `
                        <div class="lesson-item" data-course="${course.id}" data-lesson="${index}">
                            <div class="lesson-info">
                                <div class="lesson-title">
                                    <span class="lesson-icon">${getLessonIcon(lesson.type)}</span>
                                    <h4>${lesson.title}</h4>
                                </div>
                                <span class="lesson-duration">${lesson.duration}</span>
                            </div>
                            <button class="btn btn-small start-lesson-btn">Mulai</button>
                        </div>
                    `).join('')}
                </div>
            </div>
        `;
        
        // Tampilkan modal
        courseModal.style.display = 'block';
        
        // Tambahkan event listener untuk tombol tutup
        document.getElementById('close-course-modal').addEventListener('click', function() {
            courseModal.style.display = 'none';
        });
        
        // Tambahkan event listener untuk tombol mulai pelajaran
        document.querySelectorAll('.start-lesson-btn').forEach(button => {
            button.addEventListener('click', function() {
                const lessonItem = this.closest('.lesson-item');
                const courseId = lessonItem.getAttribute('data-course');
                const lessonIndex = lessonItem.getAttribute('data-lesson');
                openLesson(courseId, lessonIndex);
            });
        });
        
        // Tutup modal jika diklik di luar konten
        window.addEventListener('click', function(e) {
            if (e.target == courseModal) {
                courseModal.style.display = 'none';
            }
        });
    }
    
    // Fungsi untuk mendapatkan ikon berdasarkan tipe pelajaran
    function getLessonIcon(type) {
        switch(type) {
            case 'video':
                return '🎬';
            case 'text':
                return '📝';
            case 'interactive':
                return '🎮';
            case 'quiz':
                return '❓';
            default:
                return '📚';
        }
    }
    
    // Fungsi untuk membuka pelajaran
    function openLesson(courseId, lessonIndex) {
        const course = coursesData.find(c => c.id == courseId);
        if (!course) return;
        
        const lesson = course.lessons[lessonIndex];
        if (!lesson) return;
        
        // Cek apakah modal sudah ada
        let lessonModal = document.getElementById('lesson-modal');
        
        // Jika belum ada, buat modal baru
        if (!lessonModal) {
            lessonModal = document.createElement('div');
            lessonModal.id = 'lesson-modal';
            lessonModal.className = 'modal';
            document.body.appendChild(lessonModal);
        }
        
        // Generate konten modal berdasarkan tipe pelajaran
        let lessonContent = '';
        
        switch(lesson.type) {
            case 'video':
                lessonContent = `
                    <div class="video-container">
                        <div class="video-placeholder">
                            <div class="play-button">▶</div>
                            <p>Video: ${lesson.title}</p>
                        </div>
                        <div class="video-description">
                            <p>${lesson.content}</p>
                        </div>
                    </div>
                `;
                break;
                
            case 'text':
                lessonContent = `
                    <div class="text-content">
                        <p>${lesson.content}</p>
                    </div>
                `;
                break;
                
            case 'interactive':
                lessonContent = `
                    <div class="interactive-content">
                        <div class="interactive-placeholder">
                            <p>Konten Interaktif: ${lesson.title}</p>
                        </div>
                        <div class="interactive-description">
                            <p>${lesson.content}</p>
                        </div>
                    </div>
                `;
                break;
                
            case 'quiz':
                lessonContent = `
                    <div class="quiz-content">
                        <h4>Kuis: ${lesson.title}</h4>
                        <p>${lesson.content}</p>
                        <div class="quiz-placeholder">
                            <p>Pertanyaan kuis akan ditampilkan di sini.</p>
                            <button class="btn" id="start-quiz-btn">Mulai Kuis</button>
                        </div>
                    </div>
                `;
                break;
                
            default:
                lessonContent = `
                    <div class="default-content">
                        <p>${lesson.content}</p>
                    </div>
                `;
        }
        
        // Set konten modal
        lessonModal.innerHTML = `
            <div class="modal-content lesson-modal-content">
                <span class="close-btn" id="close-lesson-modal">&times;</span>
                <div class="lesson-header">
                    <h2>${lesson.title}</h2>
                    <span class="lesson-duration">${lesson.duration}</span>
                </div>
                <div class="lesson-body">
                    ${lessonContent}
                </div>
                <div class="lesson-navigation">
                    ${parseInt(lessonIndex) > 0 ? `<button class="btn btn-secondary prev-lesson-btn" data-course="${courseId}" data-lesson="${parseInt(lessonIndex) - 1}">« Sebelumnya</button>` : ''}
                    ${parseInt(lessonIndex) < course.lessons.length - 1 ? `<button class="btn next-lesson-btn" data-course="${courseId}" data-lesson="${parseInt(lessonIndex) + 1}">Selanjutnya »</button>` : '<button class="btn complete-course-btn">Selesai</button>'}
                </div>
            </div>
        `;
        
        // Tampilkan modal
        lessonModal.style.display = 'block';
        
        // Event listeners untuk navigasi pelajaran
        if (parseInt(lessonIndex) > 0) {
            document.querySelector('.prev-lesson-btn').addEventListener('click', function() {
                const prevCourseId = this.getAttribute('data-course');
                const prevLessonIndex = this.getAttribute('data-lesson');
                lessonModal.style.display = 'none';
                openLesson(prevCourseId, prevLessonIndex);
            });
        }
        
        if (parseInt(lessonIndex) < course.lessons.length - 1) {
            document.querySelector('.next-lesson-btn').addEventListener('click', function() {
                const nextCourseId = this.getAttribute('data-course');
                const nextLessonIndex = this.getAttribute('data-lesson');
                lessonModal.style.display = 'none';
                openLesson(nextCourseId, nextLessonIndex);
            });
        } else {
            document.querySelector('.complete-course-btn').addEventListener('click', function() {
                alert('Selamat! Anda telah menyelesaikan kursus ini.');
                lessonModal.style.display = 'none';
                
                // Update progress kursus
                const courseIndex = coursesData.findIndex(c => c.id == courseId);
                if (courseIndex !== -1) {
                    coursesData[courseIndex].progress = 100;
                    renderCourses();
                }
            });
        }
        
        // Event listener untuk tombol mulai kuis
        if (lesson.type === 'quiz') {
            document.getElementById('start-quiz-btn').addEventListener('click', function() {
                startQuiz(courseId, lessonIndex);
            });
        }
        
        // Tambahkan event listener untuk tombol tutup
        document.getElementById('close-lesson-modal').addEventListener('click', function() {
            lessonModal.style.display = 'none';
        });
        
        // Tutup modal jika diklik di luar konten
        window.addEventListener('click', function(e) {
            if (e.target == lessonModal) {
                lessonModal.style.display = 'none';
            }
        });
        
        // Update progress kursus
        updateCourseProgress(courseId, lessonIndex);
    }
    
    // Fungsi untuk memulai kuis
    function startQuiz(courseId, lessonIndex) {
        // Data kuis dummy
        const quizData = [
            {
                question: "Apa syarat utama terbentuknya sebuah negara?",
                options: [
                    "Wilayah yang jelas",
                    "Memiliki sistem ekonomi yang kuat",
                    "Memiliki angkatan perang",
                    "Memiliki mata uang sendiri"
                ],
                answer: 0
            },
            {
                question: "Bentuk negara dapat dibedakan menjadi?",
                options: [
                    "Demokratis dan otoriter",
                    "Kesatuan dan federal",
                    "Kapitalis dan sosialis",
                    "Monarki dan republik"
                ],
                answer: 1
            },
            {
                question: "Apa yang dimaksud dengan kedaulatan negara?",
                options: [
                    "Kemampuan negara untuk berperang",
                    "Kekuasaan tertinggi untuk mengatur wilayahnya sendiri",
                    "Kekayaan sumber daya alam",
                    "Jumlah penduduk yang besar"
                ],
                answer: 1
            }
        ];
        
        // Ganti konten kuis
        const quizPlaceholder = document.querySelector('.quiz-placeholder');
        
        quizPlaceholder.innerHTML = `
            <div class="quiz-questions">
                <form id="quiz-form">
                    ${quizData.map((quiz, index) => `
                        <div class="quiz-question">
                            <p><strong>Pertanyaan ${index + 1}:</strong> ${quiz.question}</p>
                            <div class="quiz-options">
                                ${quiz.options.map((option, optIndex) => `
                                    <div class="quiz-option">
                                        <input type="radio" id="q${index}_o${optIndex}" name="q${index}" value="${optIndex}">
                                        <label for="q${index}_o${optIndex}">${option}</label>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    `).join('')}
                    <button type="submit" class="btn submit-quiz-btn">Kirim Jawaban</button>
                </form>
            </div>
        `;
        
        // Event listener untuk submit kuis
        document.getElementById('quiz-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            let score = 0;
            let totalQuestions = quizData.length;
            
            // Periksa jawaban
            quizData.forEach((quiz, index) => {
                const selectedOption = document.querySelector(`input[name="q${index}"]:checked`);
                if (selectedOption && parseInt(selectedOption.value) === quiz.answer) {
                    score++;
                }
            });
            
            // Tampilkan hasil
            quizPlaceholder.innerHTML = `
                <div class="quiz-result">
                    <h4>Hasil Kuis</h4>
                    <p>Skor Anda: ${score} dari ${totalQuestions}</p>
                    <div class="score-gauge">
                        <div class="score-fill" style="width: ${(score / totalQuestions) * 100}%"></div>
                    </div>
                    <p>${getScoreMessage(score, totalQuestions)}</p>
                    <button class="btn" id="retry-quiz-btn">Coba Lagi</button>
                </div>
            `;
            
            // Event listener untuk tombol coba lagi
            document.getElementById('retry-quiz-btn').addEventListener('click', function() {
                startQuiz(courseId, lessonIndex);
            });
        });
    }
    
    // Fungsi untuk mendapatkan pesan berdasarkan skor
    function getScoreMessage(score, total) {
        const percentage = (score / total) * 100;
        
        if (percentage >= 80) {
            return "Sangat Baik! Anda memiliki pemahaman yang kuat tentang konsep dasar kenegaraan.";
        } else if (percentage >= 60) {
            return "Baik! Anda memahami sebagian besar konsep, tapi masih perlu meningkatkan beberapa area.";
        } else {
            return "Perlu belajar lagi. Cobalah untuk mengulang materi dan mencoba kuis ini lagi.";
        }
    }
    
    // Fungsi untuk memperbarui progress kursus
    function updateCourseProgress(courseId, lessonIndex) {
        const courseIndex = coursesData.findIndex(c => c.id == courseId);
        if (courseIndex === -1) return;
        
        const course = coursesData[courseIndex];
        const totalLessons = course.lessons.length;
        const progress = Math.round(((parseInt(lessonIndex) + 1) / totalLessons) * 100);
        
        // Update progress hanya jika lebih besar dari sebelumnya
        if (progress > course.progress) {
            coursesData[courseIndex].progress = progress;
            
            // Perbarui tampilan kursus
            if (document.getElementById('course-list')) {
                renderCourses();
            }
        }
    }
    
    // Fungsi untuk fitur pencarian kursus
    function setupSearch() {
        const searchInput = document.getElementById('course-search');
        if (!searchInput) return;
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            // Filter kursus berdasarkan kata kunci
            const filteredCourses = coursesData.filter(course => 
                course.title.toLowerCase().includes(searchTerm) || 
                course.description.toLowerCase().includes(searchTerm)
            );
            
            // Render ulang kursus yang difilter
            const courseContainer = document.getElementById('course-list');
            
            if (filteredCourses.length > 0) {
                courseContainer.innerHTML = '';
                
                filteredCourses.forEach(course => {
                    const courseElement = document.createElement('div');
                    courseElement.className = 'course-card';
                    courseElement.innerHTML = `
                        <div class="course-image" style="background-image: url('https://via.placeholder.com/300x200');"></div>
                        <div class="course-content">
                            <h3>${course.title}</h3>
                            <p>${course.description}</p>
                            <div class="progress-bar">
                                <div class="progress" style="width: ${course.progress}%"></div>
                            </div>
                            <div class="course-meta">
                                <span>${course.chapters} Bab</span>
                                <span>${course.level}</span>
                            </div>
                            <button class="btn course-btn" data-id="${course.id}">Mulai Belajar</button>
                        </div>
                    `;
                    courseContainer.appendChild(courseElement);
                });
                
                // Rebind event listeners
                document.querySelectorAll('.course-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const courseId = this.getAttribute('data-id');
                        openCourse(courseId);
                    });
                });
            } else {
                courseContainer.innerHTML = `
                    <div class="no-results">
                        <p>Tidak ada kursus yang sesuai dengan kata kunci "${searchTerm}"</p>
                    </div>
                `;
            }
        });
    }

    // Inisialisasi forum diskusi sederhana
    function initForum() {
        const forumContainer = document.getElementById('forum-container');
        if (!forumContainer) return;
        
        // Data forum dummy
        const forumTopics = [
            {
                id: 1,
                title: "Pentingnya Pemahaman Kenegaraan di Era Digital",
                author: "Ahmad Fauzi",
                date: "3 April 2025",
                replies: 12,
                views: 245
            },
            {
                id: 2,
                title: "Diskusi: Sistem Pemerintahan Terbaik untuk Indonesia",
                author: "Siti Nurhaliza",
                date: "1 April 2025",
                replies: 28,
                views: 387
            },
            {
                id: 3,
                title: "Hak dan Kewajiban Warga Negara dalam Praktik",
                author: "Budi Santoso",
                date: "29 Maret 2025",
                replies: 15,
                views: 213
            }
        ];
        
        // Render forum topics
        forumContainer.innerHTML = `
            <div class="forum-header">
                <h2>Forum Diskusi</h2>
                <button class="btn" id="new-topic-btn">Topik Baru</button>
            </div>
            <div class="forum-search">
                <input type="text" id="forum-search-input" placeholder="Cari topik...">
            </div>
            <div class="forum-topics">
                <div class="topic-header">
                    <div class="topic-title">Judul Topik</div>
                    <div class="topic-author">Penulis</div>
                    <div class="topic-date">Tanggal</div>
                    <div class="topic-replies">Balasan</div>
                    <div class="topic-views">Dilihat</div>
                </div>
                ${forumTopics.map(topic => `
                    <div class="topic-item" data-id="${topic.id}">
                        <div class="topic-title">${topic.title}</div>
                        <div class="topic-author">${topic.author}</div>
                        <div class="topic-date">${topic.date}</div>
                        <div class="topic-replies">${topic.replies}</div>
                        <div class="topic-views">${topic.views}</div>
                    </div>
                `).join('')}
            </div>
        `;
        
        // Event listener untuk topik baru
        document.getElementById('new-topic-btn').addEventListener('click', function() {
            alert('Fitur membuat topik baru masih dalam pengembangan.');
        });
        
        // Event listener untuk klik pada topik
        document.querySelectorAll('.topic-item').forEach(item => {
            item.addEventListener('click', function() {
                const topicId = this.getAttribute('data-id');
                openForumTopic(topicId);
            });
        });
    }
    
    // Fungsi untuk membuka topik forum
    function openForumTopic(topicId) {
        alert(`Forum topik #${topicId} masih dalam pengembangan.`);
    }
    
    // Render kursus jika halaman kursus dimuat
    if (document.getElementById('course-list')) {
        renderCourses();
        setupSearch();
    }
    
    // Inisialisasi forum jika container forum ada
    if (document.getElementById('forum-container')) {
        initForum();
    }
    
    // Cek apakah ada kursus yang sedang berlangsung
    const currentCourseId = localStorage.getItem('currentCourseId');
    if (currentCourseId) {
        const course = coursesData.find(c => c.id == currentCourseId);
        if (course) {
            // Tampilkan notifikasi untuk melanjutkan kursus
            const notifContainer = document.createElement('div');
            notifContainer.className = 'course-notification';
            notifContainer.innerHTML = `
                <p>Anda memiliki kursus yang belum selesai: <strong>${course.title}</strong></p>
                <button class="btn btn-small" id="continue-course-btn">Lanjutkan</button>
                <span class="close-notif">&times;</span>
            `;
            document.body.appendChild(notifContainer);
            
            // Event listener untuk melanjutkan kursus
            document.getElementById('continue-course-btn').addEventListener('click', function() {
                openCourse(currentCourseId);
                notifContainer.style.display = 'none';
            });
            
            // Event listener untuk menutup notifikasi
            document.querySelector('.close-notif').addEventListener('click', function() {
                notifContainer.style.display = 'none';
            });
        }
    }
}); 