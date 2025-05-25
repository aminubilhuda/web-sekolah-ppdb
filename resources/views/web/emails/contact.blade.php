<!DOCTYPE html>
<html>
<head>
    <title>Pesan Baru dari Website</title>
</head>
<body>
    <h2>Pesan Baru dari Website</h2>
    
    <p><strong>Nama:</strong> {{ $contact->nama }}</p>
    <p><strong>Email:</strong> {{ $contact->email }}</p>
    <p><strong>Subjek:</strong> {{ $contact->subjek }}</p>
    
    <h3>Pesan:</h3>
    <p>{{ $contact->pesan }}</p>
    
    <hr>
    <p>Pesan ini dikirim melalui form kontak di website sekolah.</p>
</body>
</html> 