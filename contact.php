<?php
    // Gönül Köprüsü - Güvenli İletişim Formu İşleyicisi
    
    if (isset($_POST["submit"])) {
        
        // 1. GÜVENLİK (Sanitization): Kullanıcıdan gelen verileri zararlı scriptlerden (XSS) temizle
        $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $subject_raw = htmlspecialchars(strip_tags(trim($_POST['subject'])));
        $message = htmlspecialchars(strip_tags(trim($_POST['message'])));

        // 2. PROJE BİLGİLERİ VE E-POSTA AYARLARI
        $to = 'iletisim@gonulkoprusu.org'; // E-postaların düşeceği adres
        $subject = "Gönül Köprüsü Yeni Talep: " . $subject_raw; 
        
        // 3. MAİL İÇERİĞİ (Düzenli Format)
        $body = "Gönül Köprüsü portalından yeni bir mesaj aldınız.\n\n";
        $body .= "-------------------------------------------\n";
        $body .= "Gönderen : $name\n";
        $body .= "E-Posta  : $email\n";
        $body .= "Konu     : $subject_raw\n";
        $body .= "-------------------------------------------\n\n";
        $body .= "Mesaj İçeriği:\n$message\n";

        // 4. TÜRKÇE KARAKTER VE HEADER AYARLARI (UTF-8)
        $headers = "From: webmaster@gonulkoprusu.org\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // 5. GÖNDERİM VE YÖNLENDİRME (Routing)
        mail($to, $subject, $body, $headers);
        
        // İşlem bittiğinde kullanıcının karşısına çıkacak Teşekkürler sayfası
        header("Location: thank-you.html");
        exit();
        
    } else {
        // Dosyaya yetkisiz erişimi engelle, ana sayfaya at
        header("Location: index.html");
        exit();
    }
?>