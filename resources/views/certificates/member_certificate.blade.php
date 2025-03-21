<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Piagam Penghargaan</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 90%;
            height:90%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="certificate" 
         style="position: relative; width: 290mm; height: 210mm; 
                background-image: url('{{ public_path('images/bg-sertifikat.png') }}'); 
                background-size: cover; background-position: center; 
                background-repeat: no-repeat; padding: 0px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
                color: #333; font-family: Arial, sans-serif;">
        <div class="header">
            <h1 style="padding-left: 27%; text-align: center; font-size: 1.2rem; margin-bottom: 20px; margin-top: 150px;">
                PIAGAM PENGHARGAAN
            </h1>
        </div>
        <div class="content" style="text-align: center; font-size: 0.9rem; line-height: 2;">
            <p style="padding-left: 27%; padding-right:5%;">Dengan segala kerendahan hati dan rasa syukur kepada Allah SWT, Piagam Penghargaan ini diberikan kepada:</p>
            <p class="name" style="padding-left: 27%; font-size: 1rem; font-weight: bold; margin: 10px 0;">{{ $member->name }}.</p>
            <div style="padding-left: 27%; padding-right:5%;  font-size: 0.9rem;">
                @foreach ($memberRoles as $role)
                    Atas dedikasi, loyalitas, dan peran aktifnya selama mengemban amanah dalam kepengurusan Ranting Nahdlatul Ulama (NU)
                    Sebagai {{ $role->role->name }} Pelem Kertosono periode
                    ({{ $role->start_year }} - {{ $role->end_year }})
                    <br />
                    Penghargaan ini adalah bentuk apresiasi atas segala jerih payah, waktu, tenaga, dan pikiran yang telah dicurahkan demi tegaknya ukhuwah islamiyah, menjaga tradisi Islam yang moderat, serta memperkokoh nilai-nilai kebangsaan di lingkungan Ranting NU Pelem Kertosono.
                    <br />
                    Semoga Allah SWT senantiasa melimpahkan rahmat, hidayah, dan keberkahan-Nya kepada beliau, serta menjadikan setiap langkah pengabdiannya sebagai amal jariyah yang mendatangkan pahala tiada akhir.
                @endforeach
                 <p class="name" style="padding-left: 10%; font-size: 1rem; font-weight: bold; margin: 10px 0;">Kertosono, 31 Desember 2027</p>
           
            </div>
        </div>
    </div>
</body>
</html>