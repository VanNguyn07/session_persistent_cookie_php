<?php 
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(isset($_POST['clear-session'])){
    $_SESSION = [];
    
    session_destroy(); // cancel curretn session
    // delete old session on browser
    if(ini_get("session.use_cookies")){
        $params = session_get_cookie_params();
        setcookie(session_name(), 
        '', 
        time() -42000,
        $params['path'], 
        $params['domain'],
        $params['secure'], 
        $params['httponly']);
    }

    //set up  new cookies and session 
    $path   = $params['path'] ?? '/';
    $domain = $params['domain'] ?? '';
    $secure = $params['secure'] ?? false;
    $httponly = $params['httponly'] ?? false;

        if (PHP_VERSION_ID >= 70300) {
        session_set_cookie_params([
            'lifetime' => $lifetime,
            'path'     => $path,
            'domain'   => $domain,
            'secure'   => $secure,
            'httponly' => $httponly,
            'samesite' => $params['samesite'] ?? 'Lax'
        ]);
    } else {
        // fallback cho PHP cũ: (lifetime, path, domain, secure, httponly)
        session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
    }

        // 5) Bắt đầu session mới và tạo session id mới
    session_start();
    // regen id để đảm bảo ID mới và xoá file session cũ
    session_regenerate_id(true);

    // 6) Set cookie thủ công để đảm bảo expire = lifetime (đôi khi server auto-set cookie không đúng expire)
    setcookie(
        session_name(),
        session_id(),
        time() + $lifetime,
        $path,
        $domain,
        $secure,
        $httponly
    );
    
    header("Location: ./cart.php");
    exit;
}
?>