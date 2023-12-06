<?php

$perPage = PER_PAGE;

function getTotalPages($perPage, $category = null)
{
  require_once 'connect_db.php';
  $connect = connectToDatabase();

  if ($category !== null) {
    $sql = "SELECT COUNT(Products.id) as total FROM Products
    JOIN Categories ON Products.category_id = Categories.id WHERE Categories.category_name = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $category);
  } else {
    $sql = "SELECT COUNT(id) as total FROM Products";
    $stmt = $connect->prepare($sql);
  }
  $stmt->execute();

  // Получение результата запроса
  $quantity_db = $stmt->get_result();
  $quantity = $quantity_db->fetch_assoc();

  // Закрытие соединения с базой данных
  $stmt->close();
  $connect->close();

  // Получение общего количества продуктов из результата запроса
  $totalQuantityProducts = $quantity['total'];

  // Возвращение общего количества страниц, округленного вверх
  return ceil($totalQuantityProducts / $perPage);
}


function getCurrentPage($uri)
{
  preg_match("/page\/(\d+)/", $uri, $matches);

  // Если найдено совпадение, передаем значение в $_GET['page']
  if (!empty($matches[1])) {
    $_GET['page'] = $matches[1];
  }

  return $matches;
}


function showPagination($uri, $perPage, $currentPage, $currentCategoryPage)
{
    $pagination = array();
    $totalPages = getTotalPages($perPage, $currentCategoryPage);

    $uri = preg_replace('/[&?]page=\d+/', '', $uri);

    $start_page = max(1, $currentPage - 2);
    $end_page = min($currentPage + 2, $totalPages);

    if ($totalPages > 1) {
        if ($totalPages > 5) {
            if ($currentPage == $start_page) {
                $end_page += 2;
            }
            if ($currentPage == $start_page + 1) {
                $end_page++;
            }
            if ($currentPage == $end_page) {
                $start_page -= 2;
            }
            if ($currentPage == $end_page - 1) {
                $start_page -= 1;
            }
            if ($currentPage > 1) {
                $prev_page = $currentPage - 1;
                $pagination[] = array('type' => 'prev', 'url' => $uri . $currentCategoryPage . ($prev_page > 1 ? '?page=' . $prev_page : ''));
            }

            for ($i = $start_page; $i <= $end_page; $i++) {
                if ($i == $currentPage) {
                    $pagination[] = array('type' => 'current', 'value' => $i);
                } else {
                    $newUrl = $uri . (strpos($uri, '?') !== false ? '&' : '?') . 'page=' . $i;
                    $pagination[] = array('type' => 'link', 'url' => $newUrl, 'value' => $i);
                }
            }

            if ($currentPage < $totalPages) {
                $next_page = $currentPage + 1;
                $pagination[] = array('type' => 'next', 'url' => $uri . $currentCategoryPage . '?page=' . $next_page);
            }
        }

        if ($totalPages <= 5) {
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $currentPage) {
                    $pagination[] = array('type' => 'current', 'value' => $i);
                } else {
                    $newUrl = $uri . (strpos($uri, '?') !== false ? '&' : '?') . 'page=' . $i;
                    $pagination[] = array('type' => 'link', 'url' => $newUrl, 'value' => $i);
                }
            }
        }
    }

    return $pagination;
}

