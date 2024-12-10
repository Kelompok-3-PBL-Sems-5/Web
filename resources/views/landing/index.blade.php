<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sertifikasi Dosen JTI</title>
    <style>
        .testimonial {
            background-color: #ffffff; /* putih */
            text-align: left; /* Merubah text alignment ke kiri untuk keseimbangan dengan foto */
            margin: 0px auto;
            padding: 40px;
            max-width: 1200px;
            border-radius: 8px;
        }

        .testimonial h2 {  /*tulisan */
            text-align: center;
            margin-bottom: 30px;
            font-weight: var(--fwbold);
            color: var(--navy);
            font-size: 28px;
        }

        .testimonial-content {
            display: flex; /* Menyusun item testimonial berdampingan */
            justify-content: space-between; /* Memberikan jarak antara testimonial */
            align-items: center; /* Menyelaraskan item di tengah secara vertikal */
            gap: 20px; /* Memberikan jarak antar testimonial */
        }

        .testimonial-item {
            display: flex;
            align-items: center; /* Menyelaraskan foto dan teks di tengah */
            width: 45%; /* Memberikan lebar 45% untuk setiap testimonial */
        }

        .testimonial .photo img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-right: 20px; /* Memberikan jarak antara foto dan teks */
            margin-bottom: 30px;
        }

        .testimonial .text {
            max-width: 400px; /* Membatasi lebar konten teks agar tidak terlalu lebar */
            word-wrap: break-word; /* Memastikan teks terbungkus dengan rapi */
            line-height: 1.6; /* Menambah jarak antar baris agar teks lebih mudah dibaca */
            margin-bottom: 30px;
        }

        .testimonial p {
            font-style: italic;
            font-size: 1em;
            margin-top: 10px;
            color: #555;
        }

        .testimonial .author {
            font-weight: bold;
            margin-top: 15px;
            color: #333;
        }

        .divider {
            border-left: 1px solid #ccc; /* Garis pemisah vertikal */
            height: 150px; /* Mengatur tinggi garis pemisah */
            margin: 0 20px; /* Memberikan jarak horizontal antara testimonial */
        }



        /* Team Members Section */
        .team-members {
            background: #E9F2FF; 
            text-align: center;
            padding: 50px 90px 90px 90px;
            margin: 0 auto;
            border-radius: 15px; /* Rounded corners */
        }

        /* Icon and Header */
        .team-members img.mb-16 {
            margin-bottom: 20px;
        }

        .team-members h2 { /* tulisan */
            margin-bottom: 30px;
            font-weight: var(--fwbold);
            color: var(--navy);
            font-size: 28px;
        }

        /* Team Grid */
        .team-grid {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        /* Individual Team Member Card */
        .team-member {
            background-color: #fff;
            border-radius: 15px;
            width: 200px;
            margin: 10px;
            padding: 20px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .team-member:hover {
            transform: translateY(-10px); /* Hover effect */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); /* Stronger shadow on hover */
        }

        /* Profile Image Styling */
        .team-member img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .team-member img:hover {
            transform: scale(1.1); /* Slight zoom effect on hover */
        }

        /* Text Info */
        .team-member .info {
            text-align: center;
        }

        .team-member .name {
            font-size: 1.1em;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
            font-family: 'Arial', sans-serif;
        }

        .team-member .id {
            font-size: 0.95em;
            color: #777;
        }

        .team-member .nim {
            font-size: 0.95em;
            color: #777;
        }

        .blue-text {
            color: blue;
        }

        .black-text {
            color: black;
        }


        .center-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 50px; /* Added padding top and bottom for more space */
            background-color: #F3F5F7;
            box-sizing: border-box;
        }

            /* Title Section in Center */
        .text-center {
            text-align: center;
            margin-bottom: 40px; /* Space between title and the rest */
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
            font-weight: var(--fwbold);
            color: var(--navy);
            font-size: 28px;
        }

        .title-icon {
            width: 50px;
            height: 50px;
            margin-bottom: 10px; /* Space between icon and title */
        }

        /* Section Container for the image and benefits */
        .section-container {
            display: flex;
            max-width: 1150px;
            border-radius: 16px;
            gap: 20px;
            margin-bottom: 40px; /* Space at the bottom */
        }

        /* Left Section: Large Image */
        .image-section {
            flex: 1;
            padding: 10px;
            border: 3px dashed #73A4FF;
            border-radius: 16px;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-section img {
            width: 100%; /* Ubah dari 200px ke 100% untuk responsif */
            max-width: 400px; /* Batasi ukuran maksimal jika dibutuhkan */
            height: auto; /* Sesuaikan tinggi gambar secara otomatis */
            border-radius: 20px; /* Sudut lebih tumpul */
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .section-container {
                flex-direction: column;
            }

            .image-section {
                margin-bottom: 20px; /* Tambahkan jarak bawah jika berubah ke tampilan vertikal */
            }
        }

        /* Right Section: Text and Benefits */
        .text-section {
            flex: 1;
            padding-left: 20px;
        }

        .text-section h2 {
            font-size: 24px;
            color: #8c52ff;
            margin-bottom: 20px;
        }

        /* Benefits styles */
        .benefit {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .benefit-icon {
            width: 80px;
            height: 50px;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            border-radius: 50%;
        }

            .icon-degree { background-color: #d5aef6; }
            .icon-course { background-color: #f9a8a6; }
            .icon-expert { background-color: #b4a8ff; }
            .icon-video { background-color: #f79ec3; }

        .benefit h3 {
            font-size: 20px;
            color: #f0e68c;
            margin: 0;
        }

        .benefit p {
            margin: 0;
            color: #555;
            font-size: 16px;
        }


        /* Animation for Fade-In */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body id="header">
    @include('components.navbar')
    <section class="header mb-70">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="jumbo-header mb-30">
                        Sistem Informasi <br>
                        Sertifikasi Dosen JTI
                    </h1>
                    <p class="paragraph mb-30">
                        Platform terintegrasi untuk meningkatkan efisiensi sertifikasi dan pelatihan dosen di JTI, serta memfasilitasi koordinasi dan pengelolaan yang lebih efektif
                    </p>
                    <div class="mb-50 button-container">
                        <a href="#" class="btn btn-primary">Daftar Sekarang</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="images/banner.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    {{-- Ini Fitur Utama --}}
    <section id="fitur">
    <div class="center-wrapper">
        <!-- Title Section in Center -->
        <div class="text-center">
          <img src="images/ic_best.svg" height="42" alt="Best Icon" class="mb-16">
          <h2 class="title">Fitur Utama</h2>
        </div>
      
        <!-- Section Container for Image and Benefits -->
        <section class="section-container">
          <!-- Left Section: Large Image -->
          <div class="image-section">
            <img src="images/image-fitur.png" alt="Large Image">
          </div>
          
          <!-- Right Section: Text and Benefits -->
          <div class="text-section">
            <h2><span style="color: #8c52ff;">Benefits</span> From Our Online Learning</h2>
      
            <div class="benefit">
              <div class="benefit-icon icon-degree">🎓</div>
              <div>
                <h3>Online Degrees</h3>
                <p>Earn accredited degrees from the comfort of your home, opening doors to a world of possibilities.</p>
              </div>
            </div>
      
            <div class="benefit">
              <div class="benefit-icon icon-course">📚</div>
              <div>
                <h3>Short Courses</h3>
                <p>Enhance your skills with our concise and focused short courses, designed for quick and effective learning.</p>
              </div>
            </div>
      
            <div class="benefit">
              <div class="benefit-icon icon-expert">👨‍🏫</div>
              <div>
                <h3>Training From Experts</h3>
                <p>Immerse yourself in knowledge with industry experts guiding you through hands-on experience.</p>
              </div>
            </div>
      
            <div class="benefit">
              <div class="benefit-icon icon-video">▶️</div>
              <div>
                <h3>1.5k+ Video Courses</h3>
                <p>Dive into a vast library of over 1.5k video courses covering many subjects, offering a visual learning experience.</p>
              </div>
            </div>
          </div>
        </section>
    </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="testimonial" id="testimoni">
        <div class="text-center">
            <img src="images/ic_best.svg" height="42" alt="" class="mb-16">
            <h2>Testimoni Pengguna</h2>
        </div>
        <div class="testimonial-content">
            <div class="testimonial-item">
                <div class="photo">
                    <img src="https://via.placeholder.com/100" alt="Photo Dr. Anita Sari">
                </div>
                <div class="text">
                    <p>📜 “Akses yang cepat dan sertifikasi digital sangat membantu. Pelatihannya juga relevan dengan perkembangan teknologi terbaru.”</p>
                    <div class="author">– Dr. Anita Sari, M.Kom.</div>
                </div>
            </div>
            <div class="divider"></div> <!-- Garis pemisah vertikal -->
            <div class="testimonial-item">
                <div class="photo">
                    <img src="https://via.placeholder.com/100" alt="Photo Dr. John Doe">
                </div>
                <div class="text">
                    <p>📜 “Pelatihan yang sangat berharga untuk pengembangan karir saya. Sertifikasi digital memberikan kemudahan dalam akses dan pengakuan.”</p>
                    <div class="author">– Dr. John Doe, M.Sc.</div>
                </div>
            </div>
        </div>
        <div class="testimonial-content">
            <div class="testimonial-item">
                <div class="photo">
                    <img src="https://via.placeholder.com/100" alt="Photo Dr. Anita Sari">
                </div>
                <div class="text">
                    <p>📜 “Akses yang cepat dan sertifikasi digital sangat membantu. Pelatihannya juga relevan dengan perkembangan teknologi terbaru.”</p>
                    <div class="author">– Dr. Anita Sari, M.Kom.</div>
                </div>
            </div>
            <div class="divider"></div> <!-- Garis pemisah vertikal -->
            <div class="testimonial-item">
                <div class="photo">
                    <img src="https://via.placeholder.com/100" alt="Photo Dr. John Doe">
                </div>
                <div class="text">
                    <p>📜 “Pelatihan yang sangat berharga untuk pengembangan karir saya. Sertifikasi digital memberikan kemudahan dalam akses dan pengakuan.”</p>
                    <div class="author">– Dr. John Doe, M.Sc.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Members Section -->
    <section class="team-members" id="team">
        <div class="text-center">
            <img src="images/ic_best.svg" height="42" alt="Best Icon" class="mb-16">
            <h2><span class="blue-text">Team</span> <span class="black-text">Members</span></h2>
        </div>
        <div class="team-grid">
            <!-- Team Member 1 -->
            <div class="team-member">
                <img src="images/anggota1.png" alt="Photo of Bagas Farel A.">
                <div class="info">
                    <div class="name">Bagas Farel A.</div>
                    <div class="id">Quality Assurance</div>
                    <div class="nim">2241760101</div>
                </div>
            </div>

            <!-- Team Member 2 -->
            <div class="team-member">
                <img src="images/anggota2.png" alt="Photo of annisa Azzahra">
                <div class="info">
                    <div class="name">Fannisa Azzahra</div>
                    <div class="id">Front-End Engineer</div>
                    <div class="nim">2241760102</div>
                </div>
            </div>

            <!-- Team Member 3 -->
            <div class="team-member">
                <img src="images/anggota3.png" alt="Photo of Farhan Aufa N.">
                <div class="info">
                    <div class="name">Farhan Aufa N.</div>
                    <div class="id">System Analyst</div>
                    <div class="nim">2241760103</div>
                </div>
            </div>

            <!-- Team Member 4 -->
            <div class="team-member">
                <img src="images/anggota4.png" alt="Photo of Priyatmojo E. W.">
                <div class="info">
                    <div class="name">Priyatmojo E. W.</div>
                    <div class="id">Mobile Developer</div>
                    <div class="nim">2241760110</div>
                </div>
            </div>

            <!-- Team Member 5 -->
            <div class="team-member">
                <img src="images/anggota5.png" alt="Photo of Rafi'u Mahdaviqia">
                <div class="info">
                    <div class="name">Rafi'u Mahdaviqia</div>
                    <div class="id">Back-End Engineer</div>
                    <div class="nim">2241760133</div>
                </div>
            </div>
        </div>
    </section>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous">
    
    </script>
</body>

</html>





