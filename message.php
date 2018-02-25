<?php
use Cmfcmf\OpenWeatherMap;

$data = json_decode(file_get_contents('php://input'),true);
$content = $data["content"];

// include 시작하기, 시작
if(strpos($content, "시작") !== false){
echo <<< EOD
    {
        "message": {
            "text": "교하고등학교 학생 여러분 안녕하세요.\\n저는 GHHS Siri라는 이름을 가진 교하고등학교 챗봇입니다.\\n저와 함께 이런 것들을 할 수 있어요.\\n\\n[급식]\\n오늘과 내일의 급식을 알 수 있어요.\\n\\n[날씨]\\n현재 기온과 미세먼지 정보를 알 수 있어요.\\n\\n[버스]\\n우리학교와 중심상가 주변의 버스정류장에 버스가 도착하는 시간을 알 수 있어요.\\n\\n[자유대화]\\n챗봇과 자유로운 대화를 나눌 수 있는 기능이에요!\\n\\n[개발자][후원]\\n저를 만들어준 개발자를 소개하고 개발자에게 커피 한 잔 사줄 수 있는 기능이에요 :)"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// include 처음으로, 처음
if(strpos($content, "처음") !== false){
echo <<< EOD
    {
        "message": {
            "text": "저와 함께 이런 것들을 할 수 있어요."
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// include 급식 exclude 오늘 & 내일
if($content=="급식"){
echo <<< EOD
    {
        "message": {
            "text": "언제 급식이 필요해요?"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "오늘 급식",
              "내일 급식", 
              "처음으로"
            ]
        }
    }
EOD;
}

// include 급식 & 오늘 exclude 내일
else if( strpos($content, "오늘 급식") !== false){
    $json=file_get_contents("https://URL/meal.json");
    $result=json_decode($json, true);
    $final=$result['메뉴'];
echo <<< EOD
    {
        "message": {
            "text": "$final"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// include 급식 & 내일 exclude 오늘
else if( strpos($content, "내일 급식") !== false){
/*
    $json=file_get_contents("https://URL/meal.json");
    $result=json_decode($json, true);
    $final=$result['메뉴'];
*/
echo <<< EOD
    {
        "message": {
            "text": "내일 급식 정보는 아직 개발중입니다. 조금만 기다려주세요! :)"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// include 날씨
else if(strpos($content, "날씨") !== false){
echo <<< EOD
    {
        "message": {
            "text": "어떤 정보가 필요한가요?"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "기온",
              "미세먼지",
              "처음으로"
            ]
        }
    }
EOD;
}

// include 기온
else if(strpos($content, "기온") !== false){
    require 'vendor/autoload.php';
    $lang = 'ko';
    $units = 'metric';
    $owm = new OpenWeatherMap('API KEY');
    $weather = $owm->getWeather('Seoul', $units, $lang);
    $weather_final=$weather->temperature;
    $weather_final=str_replace("&deg;C", "°C", $weather_final);
echo <<< EOD
    {
        "message": {
            "text": "현재 기온은 $weather_final 입니다."
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// include 미세먼지
else if(strpos($content, "미세먼지") !== false){
echo <<< EOD
    {
        "message": {
            "text": "미세먼지 정보는 아직 개발중입니다. 조금만 기다려주세요! :)"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 버스
else if(strpos($content, "버스") !== false){
echo <<< EOD
    {
        "message": {
            "text": "반드시 버스 정류소 이름과 노선번호를 같이 말해야 해요. 교하중앙공원과 책향기마을10-11단지는 방면도 같이 써주세요!\\n\\n예시 : '70 숲속길마을7', '책향기마을10-11단지 운정 80번'\\n\\n지원되는 범위\\n숲속길마을7단지, 트리플메디컬타운, 교하중앙공원 일산방향/금촌방향, 책향기마을10-11단지 운정방향/교하방향\\n\\n마을버스 미지원"
        }
    }
EOD;
}

// 숲속길마을7단지 70번
else if(strpos($content, "숲") !== false && strpos($content, "70") !== false){
    $url_sm_70="https://URL/bus_api.php?station=sm&route=70";
    $bus_sm_70=file_get_contents($url_sm_70);
echo <<< EOD
    {
        "message": {
            "text": "$bus_sm_70"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

//  숲속길마을7단지 1500번
else if(strpos($content, "숲") !== false && strpos($content, "1500") !== false){
    $url_sm_1500="URL/bus_api.php?station=sm&route=1500";
    $bus_sm_1500=file_get_contents($url_sm_1500);
echo <<< EOD
    {
        "message": {
            "text": "$bus_sm_1500"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 숲속길마을7단지 200번
else if(strpos($content, "숲") !== false && strpos($content, "200") !== false){
    $url_sm_200="URL/bus_api.php?station=sm&route=200";
    $bus_sm_200=file_get_contents($url_sm_200);
echo <<< EOD
    {
        "message": {
            "text": "$bus_sm_200"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }  
    }
EOD;
}

// 숲속길마을7단지 9030번
else if(strpos($content, "숲") !== false && strpos($content, "9030") !== false){
    $url_sm_9030="URL/bus_api.php?station=sm&route=9030";
    $bus_sm_9030=file_get_contents($url_sm_9030);
echo <<< EOD
    {
        "message": {
            "text": "$bus_sm_9030"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 숲속길마을7단지 9030-1번
else if(strpos($content, "숲") !== false && strpos($content, "9030-1") !== false){
    $url_sm_9030_1="URL/bus_api.php?station=sm&route=9030_1";
    $bus_sm_9030_1=file_get_contents($url_sm_9030_1);
echo <<< EOD
    {
        "message": {
            "text": "$bus_sm_9030_1"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 숲속길마을7단지 66번
else if(strpos($content, "숲") !== false && strpos($content, "66") !== false){
    $url_sm_66="URL/bus_api.php?station=sm&route=66";
    $bus_sm_66=file_get_contents($url_sm_66);
echo <<< EOD
    {
        "message": {
            "text": "$bus_sm_66"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 숲속길마을7단지 80번
else if(strpos($content, "숲") !== false && strpos($content, "80") !== false){
    $url_sm_80="URL/bus_api.php?station=sm&route=80";
    $bus_sm_80=file_get_contents($url_sm_80);
echo <<< EOD
    {
        "message": {
            "text": "$bus_sm_80"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 숲속길마을7단지 77-1번
else if(strpos($content, "숲") !== false && strpos($content, "77-1") !== false){
    $url_sm_77_1="URL/bus_api.php?station=sm&route=77_1";
    $bus_sm_77_1=file_get_contents($url_sm_77_1);
echo <<< EOD
    {
        "message": {
            "text": "$bus_sm_77_1"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 숲속길마을7단지 77-2번
else if(strpos($content, "숲") !== false && strpos($content, "77-2") !== false){
    $url_sm_77_2="URL/bus_api.php?station=sm&route=77_2";
    $bus_sm_77_2=file_get_contents($url_sm_77_2);
echo <<< EOD
    {
        "message": {
            "text": "$bus_sm_77_2"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 숲속길마을7단지 77-3번
else if(strpos($content, "숲") !== false && strpos($content, "77-3") !== false){
    $url_sm_77_3="URL/bus_api.php?station=sm&route=77_3";
    $bus_sm_77_3=file_get_contents($url_sm_77_3);
echo <<< EOD
    {
        "message": {
            "text": "$bus_sm_77_3"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 숲속길마을7단지 5600번
else if(strpos($content, "숲") !== false && strpos($content, "5600") !== false){
    $url_sm_5600="URL/bus_api.php?station=sm&route=5600";
    $bus_sm_5600=file_get_contents($url_sm_5600);
echo <<< EOD
    {
        "message": {
            "text": "$bus_sm_5600"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 트리플메디컬타운 70번
else if(strpos($content, "트") !== false && strpos($content, "70") !== false){
    $url_tm_70="URL/bus_api.php?station=tm&route=70";
    $bus_tm_70=file_get_contents($url_tm_70);
echo <<< EOD
    {
        "message": {
            "text": "$bus_tm_70"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

//  트리플메디컬타운 1500번
else if(strpos($content, "트") !== false && strpos($content, "1500") !== false){
    $url_tm_1500="URL/bus_api.php?station=tm&route=1500";
    $bus_tm_1500=file_get_contents($url_tm_1500);
echo <<< EOD
    {
        "message": {
            "text": "$bus_tm_1500"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 트리플메디컬타운 200번
else if(strpos($content, "트") !== false && strpos($content, "200") !== false){
    $url_tm_200="URL/bus_api.php?station=tm&route=200";
    $bus_tm_200=file_get_contents($url_tm_200);
echo <<< EOD
    {
        "message": {
            "text": "$bus_tm_200"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }  
    }
EOD;
}

// 트리플메디컬타운 9030번
else if(strpos($content, "트") !== false && strpos($content, "9030") !== false){
    $url_tm_9030="URL/bus_api.php?station=tm&route=9030";
    $bus_tm_9030=file_get_contents($url_tm_9030);
echo <<< EOD
    {
        "message": {
            "text": "$bus_tm_9030"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 트리플메디컬타운 9030-1번
else if(strpos($content, "트") !== false && strpos($content, "9030-1") !== false){
    $url_tm_9030_1="URL/bus_api.php?station=tm&route=9030_1";
    $bus_tm_9030_1=file_get_contents($url_tm_9030_1);
echo <<< EOD
    {
        "message": {
            "text": "$bus_tm_9030_1"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 트리플메디컬타운 66번
else if(strpos($content, "트") !== false && strpos($content, "66") !== false){
    $url_tm_66="URL/bus_api.php?station=tm&route=66";
    $bus_tm_66=file_get_contents($url_tm_66);
echo <<< EOD
    {
        "message": {
            "text": "$bus_tm_66"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 트리플메디컬타운 80번
else if(strpos($content, "트") !== false && strpos($content, "80") !== false){
    $url_tm_80="URL/bus_api.php?station=tm&route=80";
    $bus_tm_80=file_get_contents($url_tm_80);
echo <<< EOD
    {
        "message": {
            "text": "$bus_tm_80"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 트리플메디컬타운 77-1번
else if(strpos($content, "트") !== false && strpos($content, "77-1") !== false){
    $url_tm_77_1="URL/bus_api.php?station=tm&route=77_1";
    $bus_tm_77_1=file_get_contents($url_tm_77_1);
echo <<< EOD
    {
        "message": {
            "text": "$bus_tm_77_1"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 트리플메디컬타운 77-2번
else if(strpos($content, "트") !== false && strpos($content, "77-2") !== false){
    $url_tm_77_2="URL/bus_api.php?station=tm&route=77_2";
    $bus_tm_77_2=file_get_contents($url_tm_77_2);
echo <<< EOD
    {
        "message": {
            "text": "$bus_tm_77_2"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 트리플메디컬타운 77-3번
else if(strpos($content, "트") !== false && strpos($content, "77-3") !== false){
    $url_tm_77_3="URL/bus_api.php?station=tm&route=77_3";
    $bus_tm_77_3=file_get_contents($url_tm_77_3);
echo <<< EOD
    {
        "message": {
            "text": "$bus_tm_77_3"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 트리플메디컬타운 5600번
else if(strpos($content, "트") !== false && strpos($content, "5600") !== false){
    $url_tm_5600="URL/bus_api.php?station=tm&route=5600";
    $bus_tm_5600=file_get_contents($url_tm_5600);
echo <<< EOD
    {
        "message": {
            "text": "$bus_tm_5600"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 교하중앙공원 일산방면 200번
else if(strpos($content, "공") !== false && strpos($content, "200") !== false && strpos($content, "일산") !== false){
    $url_cpi_200="URL/bus_api.php?station=cpi&route=200";
    $bus_cpi_200=file_get_contents($url_cpi_200);
echo <<< EOD
    {
        "message": {
            "text": "$bus_cpi_200"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 교하중앙공원 일산방면 70번
else if(strpos($content, "공") !== false && strpos($content, "70") !== false && strpos($content, "일산") !== false){
    $url_cpi_70="URL/bus_api.php?station=cpi&route=70";
    $bus_cpi_70=file_get_contents($url_cpi_70);
echo <<< EOD
    {
        "message": {
            "text": "$bus_cpi_70"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 교하중앙공원 일산방면 77-1번
else if(strpos($content, "공") !== false && strpos($content, "77-1") !== false && strpos($content, "일산") !== false){
    $url_cpi_77_1="URL/bus_api.php?station=cpi&route=77_1";
    $bus_cpi_77_1=file_get_contents($url_cpi_77_1);
echo <<< EOD
    {
        "message": {
            "text": "$bus_cpi_77_1"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 교하중앙공원 금촌방면 200번
else if(strpos($content, "공") !== false && strpos($content, "200") !== false && (strpos($content, "파주") !== false || strpos($content, "교하") !== false || strpos($content, "금촌") !== false)){
    $url_cpp_200="URL/bus_api.php?station=cpp&route=200";
    $bus_cpp_200=file_get_contents($url_cpp_200);
echo <<< EOD
    {
        "message": {
            "text": "$bus_cpp_200"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 교하중앙공원 금촌방면 70번
else if(strpos($content, "공") !== false && strpos($content, "70") !== false && (strpos($content, "파주") !== false || strpos($content, "교하") !== false || strpos($content, "금촌") !== false)){
    $url_cpp_70="URL/bus_api.php?station=cpp&route=70";
    $bus_cpp_70=file_get_contents($url_cpp_70);
echo <<< EOD
    {
        "message": {
            "text": "$bus_cpp_70"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 교하중앙공원 금촌방면 77-1번
else if(strpos($content, "공") !== false && strpos($content, "77-1") !== false && (strpos($content, "파주") !== false || strpos($content, "교하") !== false || strpos($content, "금촌") !== false)){
    $url_cpp_77_1="URL/bus_api.php?station=cpp&route=77_1";
    $bus_cpp_77_1=file_get_contents($url_cpp_77_1);
echo <<< EOD
    {
        "message": {
            "text": "$bus_cpp_77_1"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 책향기마을10-11단지 운정방면 80번
else if(strpos($content, "책") !== false && strpos($content, "80") !== false && strpos($content, "운정") !== false){
    $url_cmu_80="URL/bus_api.php?station=cmu&route=80";
    $bus_cmu_80=file_get_contents($url_cmu_80);
echo <<< EOD
    {
        "message": {
            "text": "$bus_cmu_80"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 책향기마을10-11단지 금촌방면 80번
else if(strpos($content, "책") !== false && strpos($content, "80") !== false && (strpos($content, "파주") !== false || strpos($content, "교하") !== false || strpos($content, "금촌") !== false)){
    $url_cmg_80="URL/bus_api.php?station=cmg&route=80";
    $bus_cmg_80=file_get_contents($url_cmg_80);
echo <<< EOD
    {
        "message": {
            "text": "$bus_cmg_80"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// err 책향기마을10-11단지 방면 OK but invaild 노선
else if(strpos($content, "책") !== false && strpos($content, "80") !== true && (strpos($content, "파주") !== false || strpos($content, "교하") !== false || strpos($content, "금촌") !== false || strpos($content, "운정") !== false)){
echo <<< EOD
    {
        "message": {
            "text": "해당 노선은 입력한 정류소를 지나가지 않습니다. 확인 후 다시 입력해주세요"
        }
    }
EOD;
}

// err 교하중앙공원 방면 OK but invaild 노선
else if(strpos($content, "공") !== false && (strpos($content, "200") !== true || strpos($content, "70") !== true || strpos($content, "77-1") !== true) && (strpos($content, "파주") !== false || strpos($content, "금촌") !== false || strpos($content, "운정") !== false)){
echo <<< EOD
    {
        "message": {
            "text": "해당 노선은 입력한 정류소를 지나가지 않습니다. 확인 후 다시 입력해주세요"
        }
    }
EOD;
}

// err 노선 OK but blank 정류소, 방면
else if((strpos($content, "70") !== false || strpos($content, "1500") !== false || strpos($content, "200") !== false || strpos($content, "66") !== false || strpos($content, "80") !== false || strpos($content, "9030") !== false || strpos($content, "9030-1") !== false || strpos($content, "5600") !== false || strpos($content, "77-1") !== false || strpos($content, "77-2") !== false || strpos($content, "77-3") !== false) && (strpos($content, "일산") !== true || strpos($content, "파주") !== true || strpos($content, "금촌") !== true || strpos($content, "교하") !== true) && (strpos($content, "트") !== true || strpos($content, "숲") !== true || strpos($content, "책") !== true || strpos($content, "공") !== true)){
echo <<< EOD
    {
        "message": {
            "text": "정류소 이름(방면)이 포함되어야 합니다. 다시 작성해주세요."
        }
    }
EOD;
}

// err 정류소 OK but blank 노선, 방면
else if((strpos($content, "70") !== true || strpos($content, "1500") !== true || strpos($content, "200") !== true || strpos($content, "66") !== true || strpos($content, "80") !== true || strpos($content, "9030") !== true || strpos($content, "9030-1") !== true || strpos($content, "5600") !== true || strpos($content, "77-1") !== true || strpos($content, "77-2") !== true || strpos($content, "77-3") !== true) && (strpos($content, "일산") !== true || strpos($content, "파주") !== true || strpos($content, "금촌") !== true || strpos($content, "교하") !== true) && (strpos($content, "트") !== false || strpos($content, "숲") !== false)){
echo <<< EOD
    {
        "message": {
                "text": "노선번호가 포함되어야 합니다. 다시 작성해주세요."
        }
    }
EOD;
}

// err 정류소 OK but blank 노선, 방면
else if((strpos($content, "70") !== true || strpos($content, "1500") !== true || strpos($content, "200") !== true || strpos($content, "66") !== true || strpos($content, "80") !== true || strpos($content, "9030") !== true || strpos($content, "9030-1") !== true || strpos($content, "5600") !== true || strpos($content, "77-1") !== true || strpos($content, "77-2") !== true || strpos($content, "77-3") !== true) && (strpos($content, "일산") !== true || strpos($content, "파주") !== true || strpos($content, "금촌") !== true || strpos($content, "교하") !== true) && (strpos($content, "책") !== false || strpos($content, "공") !== false)){
echo <<< EOD
    {
        "message": {
                "text": "노선번호와 방면이 포함되어야 합니다. 다시 작성해주세요."
        }
    }
EOD;
}

// err 방면 OK but blank 노선, 정류소
else if((strpos($content, "70") !== true || strpos($content, "1500") !== true || strpos($content, "200") !== true || strpos($content, "66") !== true || strpos($content, "80") !== true || strpos($content, "9030") !== true || strpos($content, "9030-1") !== true || strpos($content, "5600") !== true || strpos($content, "77-1") !== true || strpos($content, "77-2") !== true || strpos($content, "77-3") !== true) && (strpos($content, "일산") !== false || strpos($content, "운정") !== false || strpos($content, "파주") !== false || strpos($content, "금촌") !== false || strpos($content, "교하") !== false) && (strpos($content, "트") !== true || strpos($content, "숲") !== true || strpos($content, "책") !== true || strpos($content, "공") !== true)){
echo <<< EOD
    {
        "message": {
                "text": "정류소 이름과 노선 번호가 포함되어야 합니다. 다시 작성해주세요."
        }
    }
EOD;
}

// err 정류소 OK, unnecessary 방면 OK but blank 노선
else if((strpos($content, "70") !== true || strpos($content, "1500") !== true || strpos($content, "200") !== true || strpos($content, "66") !== true || strpos($content, "80") !== true || strpos($content, "9030") !== true || strpos($content, "9030-1") !== true || strpos($content, "5600") !== true || strpos($content, "77-1") !== true || strpos($content, "77-2") !== true || strpos($content, "77-3") !== true) && (strpos($content, "일산") !== false || strpos($content, "운정") !== false || strpos($content, "파주") !== false || strpos($content, "금촌") !== false || strpos($content, "교하") !== false) && (strpos($content, "트") !== true || strpos($content, "숲") !== true || strpos($content, "책") !== false || strpos($content, "공") !== false)){
echo <<< EOD
    {
        "message": {
                "text": "노선 번호가 포함되어야 합니다. 다시 작성해주세요."
        }
    }
EOD;
}

// err 노선, 방면 OK, but blank 정류소
else if((strpos($content, "70") !== false || strpos($content, "200") !== false || strpos($content, "80") !== false || strpos($content, "77-1") !== false) && (strpos($content, "9030") !== true || strpos($content, "9030-1") !== true || strpos($content, "66") !== true || strpos($content, "77-2") !== true || strpos($content, "77-3") !== true || strpos($content, "1500") !== true || strpos($content, "5600") !== true) && (strpos($content, "일산") !== false || strpos($content, "운정") !== false || strpos($content, "파주") !== false || strpos($content, "금촌") !== false || strpos($content, "교하") !== false) && (strpos($content, "트") !== true || strpos($content, "숲") !== true || strpos($content, "책") !== true || strpos($content, "공") !== true)){
echo <<< EOD
    {
        "message": {
                "text": "정류소 이름이 포함되어야 합니다. 다시 작성해주세요."
        }
    }
EOD;
}

// include 자유대화
if(strpos($content, "자유대화") !== false){
echo <<< EOD
    {
        "message": {
            "text": "안녕?\\n(탈출하려면 <처음으로> 입력!)"
        }
    }
EOD;
}

// include 개발자
if(strpos($content, "개발자") !== false){
echo <<< EOD
    {
        "message": {
            "text": "저를 만들어준 개발자는 교하고등학교 2학년 강준영입니다.\\n\\n기능이 어렵거나 개선이 필요하다면 직접 알려주세요! 연락처는 이 챗봇 어딘가에 숨겨뒀어요!"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// include 후원
if(strpos($content, "후원") !== false){
echo <<< EOD
    {
        "message": {
            "text": "이 챗봇의 발전을 위해서 개발자가 앞으로 더 많은 밤샘을 해야합니다. 커피 한 잔이면 버틸만 할 거 같아요.\\n\\n토스 : https://get.toss.im/RErc/jIskHW8prK"
        },
        "keyboard": { 
            "type": "buttons",
            "buttons": [
              "급식",
              "날씨",
              "버스",
              "자유대화",
              "개발자",
              "후원"
            ]
        }
    }
EOD;
}

// 예외처리
else{
echo <<< EOD
    {
        "message": {
            "text": "개발 중인 기능이거나 잘못된 입력이에요ㅠㅠ"
        }
    },
    "keyboard": { 
        "type": "buttons",
        "buttons": [
          "급식",
          "날씨",
          "버스",
          "자유대화",
          "개발자",
          "후원"
        ]
    }    
EOD;
}
?>