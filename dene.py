import codequery

def analyze_php_file(php_file):
   
    engine = codequery.CodeQuery()

    
    result = engine.query(f"SELECT * FROM function WHERE file = '{php_file}'")

    #
    for function in result:
        print("Function Name:", function["name"])
        print("File:", function["file"])
        print("Line:", function["line"])
        print("Content:", function["content"])
        print("-----------------------")

if __name__ == "__main__":
    # Analiz edilecek PHP dosyası
    php_file = "giris.php"

    # PHP dosyasını analiz et
    analyze_php_file(php_file)
