<?php

include("db_config.php");
$response = array();

$email = isset($_POST["email"]) ? $_POST["email"] : "";
$sifre = isset($_POST["sifre"]) ? $_POST["sifre"] : "";
if(empty($email))
{
    $response["success"] = 0;
    $response["message"] = "Geçerli Bir Email Adresi Giriniz!!!";
}
else
{
    if(empty($sifre))
    {
        $response["success"] = 0;
        $response["message"] = "Lütfen Şifrenizi Giriniz!!!";
        $response["adsoyad"] = "0";
        $response["email"]= "0";
    }
    else
    {
        $yenisifre=sha1(sha1(sha1(md5(md5(md5($sifre))))));
        $sorgu = $bgl->prepare("select * from kisiler where email=:email and sifre=:sifre");
        $sorgu->execute(array("email"=>$email,"sifre"=>$yenisifre));
        $say=$sorgu->rowCount();
        
        if($say>0)
        {
            $kontrol=$sorgu->fetch(PDO::FETCH_ASSOC);
            $response["success"] = 1; // Başarılı giriş durumu
            $response["id"] = $kontrol["id"]; // Kullanıcının id'sini ekleyin
            $response["message"] = "Başarıyla Giriş Yapıldı";
                
        }
        else
        {
            $response["success"] = 0;
            $response["message"] = "Giriş bilgileriniz hatalı.";
        }
    }
}
echo json_encode($response);

$bgl=null;
?>
