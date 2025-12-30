<!DOCTYPE html>
<html>
<head>
    <title>Perubahan Password Akun</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px; color: #333;">
    <h2 style="color: #DB2777;">Halo, {{ $user->name }}! 👋</h2>
    
    <p>Password akun Laboratorium PTIK Anda baru saja diperbarui melalui Dashboard Mahasiswa.</p>
    
    <p>Berikut adalah password baru Anda:</p>
    
    <div style="background-color: #f3f4f6; padding: 15px; border-left: 5px solid #DB2777; font-family: monospace; font-size: 18px; margin: 20px 0;">
        {{ $plainPassword }}
    </div>
    
    <p>Jika Anda tidak merasa melakukan perubahan ini, segera hubungi Admin Laboratorium.</p>
    
    <br>
    <p style="font-size: 12px; color: #888;">Email ini dikirim otomatis oleh Sistem Inventaris Lab PTIK.</p>
</body>
</html>