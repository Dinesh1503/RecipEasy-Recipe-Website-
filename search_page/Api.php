<?php

class Api {

        private $term;
        private $key;

        public function __construct($term, $key) {
                
                $this->term = str_replace(" ", "", $term);
                $this->key = "apiKey=" . $key;
        }

        public function setKey($k){
                $key = $k;
        }

        public function searchByIngr($rank, $num) {
                
                $ingredients = "ingredients=" . $this->term;
                $number = "number=" . strval($num);
                $ranking = "ranking=" . $rank;

                $k = $this->key;
                $url = "https://api.spoonacular.com/recipes/findByIngredients?$k&$ingredients&$number&$ranking";
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_URL, $url);

                $response = curl_exec ($ch);
                curl_close ($ch);        

                $data = json_decode($response, true);
                return $data;
        }

        public function generalSearch($a, $b, $c, $d, $e, $f, $g) {

                $query = "query=" . $this->term;
                $cuisine = "cuisine=" . $a;
                $diet = "diet=" . $b;
                $k = $this->key;

                $maxReadyTime = "maxReadyTime=" .  $d;
                $maxFat = "maxFat=" .  $e;
                $maxCalories = "maxCalories=" .  $f;
                $sort = "sort=" . $g;

                $number = "number=" . $c;

                // $addRecipeInformation = "addRecipeInformation=true"; 

                $url = "https://api.spoonacular.com/recipes/complexSearch?$k&$query&$cuisine&$maxFat&$maxCalories&$maxReadyTime&$number&$sort";

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_URL, $url);

                $response = curl_exec ($ch);
                curl_close ($ch);

                $data = json_decode($response, true);

                return $data;


        }

        public function getRecipeInfo($id) {

                $k = $this->key;
                $url = "https://api.spoonacular.com/recipes/informationBulk?$k&$id";

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_URL, $url);

                $response = curl_exec ($ch);
                curl_close ($ch);        
                $data = json_decode($response, true);
                return $data;

                }
        
}
?>
