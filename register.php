<?php
include("db_config.php");
$response = array();
session_start();

$email = isset($_POST["email"]) ? $_POST["email"] : "";
$sifre = isset($_POST["sifre"]) ? $_POST["sifre"] : "";
$adisoyadi = isset($_POST["adisoyadi"]) ? $_POST["adisoyadi"] : "";


if(empty($email))
{
    $response["success"] = 0;
    $response["message"] = "Lütfen E-Mail Adresi Giriniz!!!";
    echo json_encode($response);
}    
else
{
    if(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        $response["success"] = 0;
        $response["message"] = "Geçerli Bir E-mail Adresi Giriniz!!!";
        echo json_encode($response);
    }
    else
    {
        if(empty($sifre))
        {
            $response["success"] = 0;
            $response["message"] = "Lütfen Şifrenizi Giriniz!!!";
            echo json_encode($response);
        }
        else
        {
            if(empty($adisoyadi))
            {
                $response["success"] = 0;
                $response["message"] = "Lütfen Adınızı Soyadınızı Giriniz!!!";
                echo json_encode($response);
            }
            else
            {

                $varmi=$bgl->prepare("select * from kisiler where email=:email");
                $varmi->execute(array("email"=>$email));
                $varmisay=$varmi->rowCount();
                if($varmisay>0)
                {
                    $response["success"] = 0;
                    $response["message"] = "E-Mail Adresi Kayıtlı.";
                    echo json_encode($response);
                }
                else
                {
                    if (strlen($sifre)<6) 
                    {
                        $response["success"] = 0;
                        $response["message"] = "Lütfen Şifrenizi 6 Veya 6 Haneden Fazla Olarak Belirleyin";
                        echo json_encode($response);
                    }
                    else
                    {
                    $yenisifre=sha1(sha1(sha1(md5(md5(md5($sifre))))));
                    $sorgu = $bgl->prepare("insert into kisiler set email=:email,adisoyadi=:adisoyadi,sifre=:sifre");
                    $cal = $sorgu->execute(array("email"=>$email,"adisoyadi"=>$adisoyadi,"sifre"=>$yenisifre));
                    
                    if($cal)
                    {
                        $response["success"] = "1";
                        $response["message"] = "başarılı";        
                        
                        echo json_encode($response);
                    }
                    else
                    {
                        $response["success"] = 0;
                        $response["message"] = "Giriş bilgileriniz hatalı.";
                        echo json_encode($response);
                    }
                }
                }
            }
        }
    }
} 
$bgl=null;
?>
