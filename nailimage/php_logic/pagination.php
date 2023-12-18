<?php

/**
 * Získání celkového počtu stránek pro zobrazení produktů na základě počtu produktů na stránku,
 * kategorie a/nebo hledaného výrazu.
 *
 * @param int      $perPage Počet produktů na stránku.
 * @param string   $category Volitelný parametr: název kategorie pro filtrování produktů.
 * @param string   $search Volitelný parametr: hledaný výraz pro filtrování produktů.
 *
 * @return int Celkový počet stránek pro zobrazení produktů.
 */
function getTotalPages($perPage, $category = null, $search = null)
{
    require_once 'connect_db.php';
    // Připojení k databázi
    $connect = connectToDatabase();
    // Sestavení SQL dotazu na získání celkového počtu produktů
    if ($category !== null) {
        $sql = "SELECT COUNT(Products.id) as total FROM Products
    JOIN Categories ON Products.category_id = Categories.id_category WHERE Categories.name_category = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("s", $category);
    } else {
        $sql = "SELECT COUNT(id) as total FROM Products";
        $stmt = $connect->prepare($sql);
    }
    // Provedení připraveného dotazu
    $stmt->execute();

    // Získání výsledků dotazu
    $quantity_db = $stmt->get_result();
    $quantity = $quantity_db->fetch_assoc();

    // Uzavření připraveného dotazu a připojení k databázi
    $stmt->close();
    $connect->close();

    // Získání celkového počtu produktů z výsledků dotazu
    $totalQuantityProducts = $quantity['total'];

    // Vrácení celkového počtu stránek, zaokrouhleného nahoru
    return ceil($totalQuantityProducts / $perPage);
}


/**
 * Zobrazí odkazy na stránkování na základě aktuální stránky a celkového počtu stránek.
 *
 * @param string $uri                   Aktuální URI, které bude použito pro odkazy.
 * @param int    $perPage               Počet položek na stránku.
 * @param int    $currentPage           Aktuální stránka.
 * @param string $currentCategoryPage   Volitelný parametr: název aktuální kategorie pro filtrování.
 * @param string $searchValue           Volitelný parametr: hledaný výraz pro filtrování.
 *
 * @return array Pole s informacemi pro zobrazení stránkování.
 */
function showPagination($uri, $perPage, $currentPage, $currentCategoryPage = null, $searchValue = null)
{
    $pagination = array();
    $totalPages = getTotalPages($perPage, $currentCategoryPage, $searchValue);
    // Odstranění parametru 'page' z aktuálního URI
    $uri = preg_replace('/[&?]page=\d+/', '', $uri);
    // Určení rozsahu stránek pro zobrazení
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
    // Vrácení odkazů
    return $pagination;
}
