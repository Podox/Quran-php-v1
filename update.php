<?php
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = 'podoxito';
$dbName = 'quran';
session_start(); // Start or resume the session

// Check if input_username is set in the session
if(isset($_SESSION['user'])) {
    $input_username = $_SESSION['user'];
} else {
    // Handle the case where input_username is not set in the session
    // For example, redirect the user to the login page
header("location: logout.php");    
echo "eror";
    exit();
}

// Initialize error message variable
$error_message = NULL;
$success_message = NULL;

// Create connection
$conn = mysqli_connect($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id from quran where name ='$input_username'";
$idu_result = $conn->query($sql);

if ($idu_result->num_rows > 0) {
    // Fetch the ID value from the query result
    $idu_row = $idu_result->fetch_assoc();
    $idu = $idu_row['id'];
} else {
    // Handle the case where the ID is not found
    echo "Error: ID not found";
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $aaya = $_POST["aaya"];
    $sura = $_POST["sura"];
    
    // Prepare and execute SQL statement to update the database
    $sql = "UPDATE quran SET aaya = $aaya, sura = $sura WHERE id = $idu";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Record updated successfully";
    } else {
        $error_message = "Error updating record: " . $conn->error;
    }
    // Prepare and execute SQL statement to insert a log record into the update-log table
$update_date = date('Y-m-d H:i:s'); // Get the current date and time
$sql_insert_log = "INSERT INTO updata (id,Name, sura,aaya, date) VALUES ($idu,'  $input_username', $sura,$aaya, '$update_date')";
$conn->query($sql_insert_log); // Execute the SQL statement

// Check if the insertion was successful
if ($conn->affected_rows > 0) {
    // Log record inserted successfully
    $success_message .= " Log record inserted successfully.";
} else {
    // Log record insertion failed
    $error_message .= " Error inserting log record: " . $conn->error;
}
} 
$_SESSION['variable'] = "value";
// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="quran.png" type="image/x-icon">
<title>Quran Form</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    /* Custom CSS for greeting */
    .greeting {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
    }
    .image-container {
        max-width: 80%;
    }
    
    .responsive-img {
        width: 100%;
        height: auto;
        display: block; /* Ensures image is centered within container */
    }
</style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">༼ つ ◕_◕ ༽つUpdate your Progression🕌⋆˙⟡♡</h2>
    
    
    
    <!-- Success and error messages -->
    <?php if ($success_message): ?>
    <div class="alert alert-success" role="alert">
        <?php echo $success_message; ?>
    </div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error_message; ?>
    </div>
    <?php endif; ?>
    <form action="" method="post" onsubmit="return validateForm()">
        <div class="mb-3">
            <label for="aaya" class="form-label">Aaya: آية</label>
            <input type="number" class="form-control" id="aaya" name="aaya" required>
        </div>
        <div class="mb-3">
            <label for="sura" class="form-label">Sura: سورة</label>
            <select class="form-select" id="sura" name="sura" required>
                <option value="">Select Sura</option>
                <!-- Options for sura selection -->
<option value="1">الفاتحة</option>
<option value="2">البقرة</option>
<option value="3">آل عمران</option>
<option value="4">النساء</option>
<option value="5">المائدة</option>
<option value="6">الأنعام</option>
<option value="7">الأعراف</option>
<option value="8">الأنفال</option>
<option value="9">التوبة</option>
<option value="10">يونس</option>
<option value="11">هود</option>
<option value="12">يوسف</option>
<option value="13">الرعد</option>
<option value="14">إبراهيم</option>
<option value="15">الحجر</option>
<option value="16">النحل</option>
<option value="17">الإسراء</option>
<option value="18">الكهف</option>
<option value="19">مريم</option>
<option value="20">طه</option>
<option value="21">الأنبياء</option>
<option value="22">الحج</option>
<option value="23">المؤمنون</option>
<option value="24">النور</option>
<option value="25">الفرقان</option>
<option value="26">الشعراء</option>
<option value="27">النمل</option>
<option value="28">القصص</option>
<option value="29">العنكبوت</option>
<option value="30">الروم</option>
<option value="31">لقمان</option>
<option value="32">السجدة</option>
<option value="33">الأحزاب</option>
<option value="34">سبإ</option>
<option value="35">فاطر</option>
<option value="36">يس</option>
<option value="37">الصافات</option>
<option value="38">ص</option>
<option value="39">الزمر</option>
<option value="40">غافر</option>
<option value="41">فصلت</option>
<option value="42">الشورى</option>
<option value="43">الزخرف</option>
<option value="44">الدخان</option>
<option value="45">الجاثية</option>
<option value="46">الأحقاف</option>
<option value="47">محمد</option>
<option value="48">الفتح</option>
<option value="49">الحجرات</option>
<option value="50">ق</option>
<option value="51">الذاريات</option>
<option value="52">الطور</option>
<option value="53">النجم</option>
<option value="54">القمر</option>
<option value="55">الرحمن</option>
<option value="56">الواقعة</option>
<option value="57">الحديد</option>
<option value="58">المجادلة</option>
<option value="59">الحشر</option>
<option value="60">الممتحنة</option>
<option value="61">الصف</option>
<option value="62">الجمعة</option>
<option value="63">المنافقون</option>
<option value="64">التغابن</option>
<option value="65">الطلاق</option>
<option value="66">التحريم</option>
<option value="67">الملك</option>
<option value="68">القلم</option>
<option value="69">الحاقة</option>
<option value="70">المعارج</option>
<option value="71">نوح</option>
<option value="72">الجن</option>
<option value="73">المزمل</option>
<option value="74">المدثر</option>
<option value="75">القيامة</option>
<option value="76">الإنسان</option>
<option value="77">المرسلات</option>
<option value="78">النبأ</option>
<option value="79">النازعات</option>
<option value="80">عبس</option>
<option value="81">التكوير</option>
<option value="82">الإنفطار</option>
<option value="83">المطففين</option>
<option value="84">الإنشقاق</option>
<option value="85">البروج</option>
<option value="86">الطارق</option>
<option value="87">الأعلى</option>
<option value="88">الغاشية</option>
<option value="89">الفجر</option>
<option value="90">البلد</option>
<option value="91">الشمس</option>
<option value="92">الليل</option>
<option value="93">الضحى</option>
<option value="94">الشرح</option>
<option value="95">التين</option>
<option value="96">العلق</option>
<option value="97">القدر</option>
<option value="98">البينة</option>
<option value="99">الزلزلة</option>
<option value="100">العاديات</option>
<option value="101">القارعة</option>
<option value="102">التكاثر</option>
<option value="103">العصر</option>
<option value="104">الهمزة</option>
<option value="105">الفيل</option>
<option value="106">قريش</option>
<option value="107">الماعون</option>
<option value="108">الكوثر</option>
<option value="109">الكافرون</option>
<option value="110">النصر</option>
<option value="111">المسد</option>
<option value="112">الإخلاص</option>
<option value="113">الفلق</option>
<option value="114">الناس</option>
            </select>
        </div>
        <!-- Error message div -->
        <div id="errorMessage" class="mb-3" style="color: red; display: none;">
            The selected verse number cannot exceed the maximum number of verses available for this sura.
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn btn-secondary" onclick="returni()">Return</button>
        <img class="responsive-img" src="arabic.png" alt="Description of the image">
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Define maximum number of verses for each sura
    var maxVerses = {
        // Add more suras and their maximum verses here
        
    "1": 7,    // Surah Al-Fatiha
    "2": 286,  // Surah Al-Baqarah
    "3": 200,  // Surah Aal-E-Imran
    "4": 176,  // Surah An-Nisa
    "5": 120,  // Surah Al-Maidah
    "6": 165,  // Surah Al-An'am
    "7": 206,  // Surah Al-A'raf
    "8": 75,   // Surah Al-Anfal
    "9": 129,  // Surah At-Tawbah
    "10": 109, // Surah Yunus
    "11": 123, // Surah Hud
    "12": 111, // Surah Yusuf
    "13": 43,  // Surah Ar-Ra'd
    "14": 52,  // Surah Ibrahim
    "15": 99,  // Surah Al-Hijr
    "16": 128, // Surah An-Nahl
    "17": 111, // Surah Al-Isra
    "18": 110, // Surah Al-Kahf
    "19": 98,  // Surah Maryam
    "20": 135, // Surah Ta-Ha
    "21": 112, // Surah Al-Anbiya
    "22": 78,  // Surah Al-Hajj
    "23": 118, // Surah Al-Mu'minun
    "24": 64,  // Surah An-Nur
    "25": 77,  // Surah Al-Furqan
    "26": 227, // Surah Ash-Shu'ara
    "27": 93,  // Surah An-Naml
    "28": 88,  // Surah Al-Qasas
    "29": 69,  // Surah Al-Ankabut
    "30": 60,  // Surah Ar-Rum
    "31": 34,  // Surah Luqman
    "32": 30,  // Surah As-Sajda
    "33": 73,  // Surah Al-Ahzab
    "34": 54,  // Surah Saba
    "35": 45,  // Surah Fatir
    "36": 83,  // Surah Ya-Sin
    "37": 182, // Surah As-Saffat
    "38": 88,  // Surah Sad
    "39": 75,  // Surah Az-Zumar
    "40": 85,  // Surah Ghafir
    "41": 54,  // Surah Fussilat
    "42": 53,  // Surah Ash-Shura
    "43": 89,  // Surah Az-Zukhruf
    "44": 59,  // Surah Ad-Dukhan
    "45": 37,  // Surah Al-Jathiyah
    "46": 35,  // Surah Al-Ahqaf
    "47": 38,  // Surah Muhammad
    "48": 29,  // Surah Al-Fath
    "49": 18,  // Surah Al-Hujurat
    "50": 45,  // Surah Qaf
    "51": 60,  // Surah Adh-Dhariyat
    "52": 49,  // Surah At-Tur
    "53": 62,  // Surah An-Najm
    "54": 55,  // Surah Al-Qamar
    "55": 78,  // Surah Ar-Rahman
    "56": 96,  // Surah Al-Waqi'ah
    "57": 29,  // Surah Al-Hadid
    "58": 22,  // Surah Al-Mujadila
    "59": 24,  // Surah Al-Hashr
    "60": 13,  // Surah Al-Mumtahanah
    "61": 14,  // Surah As-Saff
    "62": 11,  // Surah Al-Jumu'ah
    "63": 11,  // Surah Al-Munafiqun
    "64": 18,  // Surah At-Taghabun
    "65": 12,  // Surah At-Talaq
    "66": 12,  // Surah At-Tahrim
    "67": 30,  // Surah Al-Mulk
    "68": 52,  // Surah Al-Qalam
    "69": 52,  // Surah Al-Haqqah
    "70": 44,  // Surah Al-Ma'arij
    "71": 28,  // Surah Nuh
    "72": 28,  // Surah Al-Jinn
    "73": 20,  // Surah Al-Muzzammil
    "74": 56,  // Surah Al-Muddathir
    "75": 40,  // Surah Al-Qiyamah
    "76": 31,  // Surah Al-Insan
    "77": 50,  // Surah Al-Mursalat
    "78": 40,  // Surah An-Naba
    "79": 46,  // Surah An-Nazi'at
    "80": 42,  // Surah Abasa
    "81": 29,  // Surah At-Takwir
    "82": 19,  // Surah Al-Infitar
    "83": 36,  // Surah Al-Mutaffifin
    "84": 25,  // Surah Al-Inshiqaq
    "85": 22,  // Surah Al-Buruj
    "86": 17,  // Surah At-Tariq
    "87": 19,  // Surah Al-A'la
    "88": 26,  // Surah Al-Ghashiyah
    "89": 30,  // Surah Al-Fajr
    "90": 20,  // Surah Al-Balad
    "91": 15,  // Surah Ash-Shams
    "92": 21,  // Surah Al-Lail
    "93": 11,  // Surah Ad-Duha
    "94": 8,   // Surah Ash-Sharh
    "95": 8,   // Surah At-Tin
    "96": 19,  // Surah Al-Alaq
    "97": 5,   // Surah Al-Qadr
    "98": 8,   // Surah Al-Bayyinah
    "99": 8,   // Surah Az-Zalzalah
    "100": 11, // Surah Al-Adiyat
    "101": 11, // Surah Al-Qari'ah
    "102": 8,  // Surah At-Takathur
    "103": 3,  // Surah Al-Asr
    "104": 9,  // Surah Al-Humazah
    "105": 5,  // Surah Al-Fil
    "106": 4,  // Surah Quraish
    "107": 7,  // Surah Al-Ma'un
    "108": 3,  // Surah Al-Kawthar
    "109": 6,  // Surah Al-Kafirun
    "110": 3,  // Surah An-Nasr
    "111": 5,  // Surah Al-Masad
    "112": 4,  // Surah Al-Ikhlas
    "113": 5,  // Surah Al-Falaq
    "114": 6   // Surah An-Nas
    };

    function validateForm() {
        var sura = document.getElementById("sura").value;
        var aaya = document.getElementById("aaya").value;

        // Check if the selected sura exists in maxVerses
        if (maxVerses.hasOwnProperty(sura)) {
            // Compare the selected aaya with the maximum verses for the sura
            if (parseInt(aaya) > maxVerses[sura]) {
                document.getElementById("errorMessage").innerHTML = "Max Aayat is " + maxVerses[sura] + " for this sura.";
                document.getElementById("errorMessage").style.display = "block";
                return false; // Prevent form submission
            } if (aaya < 0){
                document.getElementById("errorMessage").innerHTML = "Negative numbers  ಠ_ಠ";
                document.getElementById("errorMessage").style.display = "block";
                return false;
            }else {
                document.getElementById("errorMessage").style.display = "none";
            }
        }

        return true; // Allow form submission
    }

    function returni() {
        window.location.href = "index1.php";
    }
</script>
</body>
</html>
