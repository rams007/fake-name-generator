<?php
/**
 * Created by PhpStorm.
 * User: RAMS
 * Date: 25.03.2019
 * Time: 9:39
 */

namespace FakeNameGenerator;


class FakeNameGeneratorAPI
{

    /**
     * If you need just random user without any settings
     */
    public function getRandom()
    {
        $this->CreateIdentity();
    }

    /**
     * @param string $gender  Male or female
     * @param string $nameSet please use one of constants from FakeNameGeneratorNameSet class
     * @param string $country please use one of constans from FakeNameGeneratorCountries class
     * @return array
     */
    public function CreateIdentity($gender = '', $nameSet = '', $country = '')
    {
        if (empty($gender) AND empty($nameSet) AND empty($country)) {
            $url = "https://www.fakenamegenerator.com/";
        } else {
            if (empty($gender) OR empty($nameSet) OR empty($country)) {
                return ['error' => true, 'msg' => 'You must Enter Gender, Name Set and country'];
            }else{
                $url = "https://www.fakenamegenerator.com/gen-".$gender."-".$nameSet."-".$country.".php";
            }
        }

        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 5);
            $out = curl_exec($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);
            if (empty($out)) {
                return ['error' => true, 'msg' => 'Empty server response', 'info'=>$info];
            }

            $UserIdentity = new \stdClass();

            preg_match("/<h3>(.*?)</", $out, $match);
            $UserIdentity->Name = trim($match[1]);

            preg_match("/\"adr\">(.*?)<\//s", $out, $match);
            $address = trim($match[1]);

            preg_match("/(.*?)<br \/>(.*?)$/", $address, $match);
            $UserIdentity->AddressLine = trim($match[1]);
            $UserIdentity->AddressLine2 = trim($match[2]);
            $UserIdentity->AddressFull = $UserIdentity->AddressLine . " " . $UserIdentity->AddressLine2;

            preg_match("/<.dt>\\n\\s*<dd>(.*)<./", $out, $match);
            $UserIdentity->MaidenName = trim($match[1]);

            preg_match("/SSN<.dt><dd>(.*?)<div class=/", $out, $match);
            $UserIdentity->SSN = !empty($match[1]) ? trim($match[1]) : "N/A";

            preg_match("/Phone<.dt>\\n\\s*<dd>(.*?)<.dd>/", $out, $match);
            $UserIdentity->Phone = trim($match[1]);

            preg_match("/Country code<.dt>\\n\\s*<dd>(.*?)<.dd>/", $out, $match);
            $UserIdentity->CountryCode = trim($match[1]);

            preg_match("/Birthday<.dt>\\n\\s*<dd>(.*?)<.dd>/", $out, $match);
            $UserIdentity->Birthday = trim($match[1]);
            $UserIdentity->Age = round((time() - strtotime($UserIdentity->Birthday)) / (60 * 60 * 24 * 365));

            preg_match("/Email Address<.dt>\n\n\s*<dd>(.*?)<div/", $out, $match);
            $UserIdentity->Email = trim($match[1]);

            preg_match("/Username<.dt>\n\s*<dd>(.*?)<.dd>/", $out, $match);
            $UserIdentity->Username = trim($match[1]);

            preg_match("/Password<.dt>\n\s*<dd>(.*?)<.dd>/", $out, $match);
            $UserIdentity->Password = trim($match[1]);

            preg_match("/Website<.dt>\n\s*<dd>(.*?)<.dd>/", $out, $match);
            $UserIdentity->Website = trim($match[1]);

            preg_match("/Browser user agent<.dt>\n\s*<dd>(.*?)<.dd>/", $out, $match);
            $UserIdentity->UserAgent = trim($match[1]);

            preg_match("/Finance<\/h3>(.*?)<\/dl/s", $out, $match);

            preg_match("/<dt>(.*?)<.dt>/", $match[1], $matchCardNumber);
            preg_match("/<dd>(.*?)<.dd>/", $match[1], $matchCardType);
            $UserIdentity->CardNumber = trim($matchCardNumber[1]);
            $UserIdentity->CardType = trim($matchCardType[1]);

            preg_match("/<dt>Expires<.dt>\n\s*<dd>(.*?)<\/dd>/", $out, $match);
            $UserIdentity->CardExpiration = trim($match[1]);

            preg_match("/<dt>Company<.dt>\n\s*<dd>(.*?)<\/dd>/", $out, $match);
            $UserIdentity->Company = trim($match[1]);

            preg_match("/<dt>Occupation<.dt>\n\s*<dd>(.*?)<\/dd>/", $out, $match);
            $UserIdentity->Occupation = trim($match[1]);

            preg_match("/<dt>Height<.dt>\n\s*<dd>(.*?)<\/dd>/", $out, $match);
            $UserIdentity->Height = trim($match[1]);

            preg_match("/<dt>Weight<.dt>\n\s*<dd>(.*?)<\/dd>/", $out, $match);
            $UserIdentity->Weight = trim($match[1]);

            preg_match("/<dt>Blood type<.dt>\n\s*<dd>(.*?)<.dd>/", $out, $match);
            $UserIdentity->BloodType = trim($match[1]);

            preg_match("/<dt>Vehicle<.dt>\n\s*<dd>(.*?)<.dd>/", $out, $match);
            $UserIdentity->Vehicle = trim($match[1]);
            return ['error' => false, 'userIdentity' => $UserIdentity];

        } else {
            return ['error' => true, 'msg' => 'Cant initialize curl'];
        }
    }
}