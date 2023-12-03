<?php


function getCurrenCategotyPage ($uri){
  preg_match("/category\/(\w+)/", $uri, $matches);

    // Если найдено совпадение, передаем значение в $_GET['page']
    if (!empty($matches[1])) {
        $_GET['category_page'] = $matches[1];
    }

    return $matches;
}