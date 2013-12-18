<?php

 /* This script was written by Thorsten Rotering, 2009.
  *
  * This script is free software: you can redistribute it and/or modify
  * it under the terms of the Lesser GNU General Public License (LGPL) as
  * published by the Free Software Foundation, either version 3 of the
  * License or (at your option) any later version.
  *
  * This script is distributed in the hope that it will be useful, but
  * WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * You should received a copy of the GNU General Public License and the
  * Lesser GNU General Public License with this script. If not, see
  * <http://www.gnu.org/licenses/>. */


 /* Check if the script can be interpreted by the local php version */
 if (version_compare('5.0.0', PHP_VERSION, '>'))
  exit('The PageNavigation-class requires PHP5 or above. Please update your PHP interpreter in order to use this class on your system.');


 class PageNavigation {
  const version = '1.0.4';

  /* Read-only attributes */
  private $parameter_name;
  private $cur_page_id;
  private $first_item_id;
  private $last_item_id;
  private $item_count;
  private $items_per_page;
  private $page_count;
  private $sql_limit;

  /* Settings */
  public $url = '?%p';
  public $show_navlinks = true;
  public $use_xhtml = true;
  public $link_count_outer = 2;
  public $link_count_inner = 2;

  /* HTML classes */
  public $html_class_pagebar = 'pagebar';
  public $html_class_pagebar_label = 'pagebar-label';
  public $html_class_pagebar_curpage = 'pagebar-curpage';
  public $html_class_pagebar_pagelink = 'pagebar-pagelink';
  public $html_class_pagebar_navlink_prev = 'pagebar-navlink pagebar-navlink-prev';
  public $html_class_pagebar_navlink_next = 'pagebar-navlink pagebar-navlink-next';
  public $html_class_pageselbox = 'pageselbox';
  public $html_class_pageselbox_select = 'pageselbox-select';
  public $html_class_pageselbox_button = 'pageselbox-button';

  /* HTML labels */
  public $html_label_pagebar = 'Seiten:';
  public $html_label_pageselbox_button = 'Los!';
  public $html_label_pagelink = 'Gehe zur Seite %p';
  public $html_label_pagelink_divider = '&hellip;';
  public $html_label_navlink_prev = 'Vorherige Seite';
  public $html_label_navlink_prev_symbol = '&laquo;';
  public $html_label_navlink_next = 'Nächste Seite';
  public $html_label_navlink_next_symbol = '&raquo;';



  /* The constructor */
  public function __construct ($item_count, $items_per_page, $parameter_name = 'p') {

   /* Set the items per subpage */
   $this->items_per_page = max((int)$items_per_page, 1);

   /* Set the number of items overall */
   $this->item_count = max((int)$item_count, 0);

   /* Set the paramter name */
   $this->parameter_name = $parameter_name;

   /* Calculate the number of subpages */
   $this->page_count = max(ceil($this->item_count / $this->items_per_page), 1);

   /* Get the current subpage from the REQUEST */
   $this->cur_page_id = max(min((int)$_REQUEST[$this->parameter_name], $this->page_count), 1);

   /* Calculate the first and last item ID and the SQL limits */
   $offset = ($this->cur_page_id - 1) * $this->items_per_page;
   $this->first_item_id = $offset + 1;
   $this->last_item_id = min($offset + $this->items_per_page, $this->item_count);
   $this->sql_limit = (string)$offset . ', ' . (string)$this->items_per_page;
  }


  /* Enable read-access to all attributes */
  public function __get ($var_name) {
   return $this->$var_name;
  }


  /* Creates an HTML page bar */
  public function createPageBar ($html_id = 'pagebar') {

   /* Initial calculations */
   $minblocksize = $this->link_count_outer + $this->link_count_inner;

   /* Create the container */
   $output = '<div id="' . $html_id . '" class="' . $this->html_class_pagebar . '">' .
             '<span class="' . $this->html_class_pagebar_label . '">' . $this->html_label_pagebar . '</span> ';

   /* Create the link to the previous page */
   if ($this->show_navlinks && $this->cur_page_id > 1)
    $output .= '<a class="' . $this->html_class_pagebar_navlink_prev . '" href="' . $this->createUrl($this->cur_page_id - 1) .
               '" title="' . $this->html_label_navlink_prev . '" rel="prev">' . $this->html_label_navlink_prev_symbol . '</a> ';

   /* Create the left link block of the subpages */
   if ($this->cur_page_id > $minblocksize + 1)
    $output .= $this->createPageLinks(1, $this->link_count_outer) .
               $this->html_label_pagelink_divider . ' ' .
               $this->createPageLinks($this->cur_page_id - $this->link_count_inner, $this->cur_page_id - 1);
   else
    $output .= $this->createpageLinks(1, $this->cur_page_id - 1);

   /* Create the information about the current page */
   $output .= '<strong class="' . $this->html_class_pagebar_curpage . '">' . $this->cur_page_id . '</strong> ';

   /* Create the right link block of the subpages */
   if ($this->cur_page_id < $this->page_count - $minblocksize)
    $output .= $this->createPageLinks($this->cur_page_id + 1, $this->cur_page_id + $this->link_count_inner) .
               $this->html_label_pagelink_divider . ' ' .
               $this->createPageLinks($this->page_count - $this->link_count_outer + 1, $this->page_count);
   else
    $output .= $this->createPageLinks($this->cur_page_id + 1, $this->page_count);

   /* Create the link to the next page */
   if ($this->show_navlinks && $this->cur_page_id < $this->page_count)
    $output .= '<a class="' . $this->html_class_pagebar_navlink_next . '" href="' . $this->createUrl($this->cur_page_id + 1) .
               '" title="' . $this->html_label_navlink_next . '" rel="next">' . $this->html_label_navlink_next_symbol . '</a>';

   /* Finalize */
   $output .= '</div>';
   return $output;
  }


  /* Creates an HTML page selection box */
  public function createPageSelBox ($html_id = 'pageselbox') {

   /* Precreate the selection box */
   $selbox = '<select name="' . $this->parameter_name . '" class="' . $this->html_class_pageselbox_select . '" size="1">';

   for ($n = 1; $n <= $this->page_count; $n++)
   	$selbox .= '<option value="' . (string)$n . '"' .
   	           ($n == $this->cur_page_id ? ' selected="selected"' : '') . '>' . (string)$n . '</option>';

   $selbox .= '</select>';

   /* Create the container */
   $output .= '<div id="' . $html_id . '" class="' . $this->html_class_pageselbox . '">' .
              '<form action="' . $this->createUrl(0) . '" method="post"><div>' .
              str_replace('%p', $selbox, $this->html_label_pagelink) . ' ' .
              '<input type="submit" class="' . $this->html_class_pageselbox_button . '" value="' . $this->html_label_pageselbox_button . '"' .
              ($this->use_xhtml ? ' />' : '>' ) .
              '</div></form></div>';

   /* Finalize */
   return $output;
  }


  /* Creates a continuous list of links to subpages */
  private function createPageLinks ($start, $end) {
   $output = '';
   for ($n = $start; $n <= $end; $n++)
    $output .= '<a class="' . $this->html_class_pagebar_pagelink . '" href="' . $this->createUrl($n) .
               '" title="' . $this->createTitle($n) . '">' . (string)$n . '</a> ';
   return $output;
  }


  /* Creates an URL with the passed page ID using the given template */
  private function createUrl ($page_id) {
   if ($page_id <= 0) {
   	$url = str_replace('&%p', '', $this->url);
   	$url = str_replace('?%p', '', $url);
   } else {
    $url = str_replace('%p', $this->parameter_name . '=' . (string)$page_id, $this->url);
   }

   $url = htmlspecialchars($url);
   return $url;
  }


 /* Creates a title with the passed page ID using the given template */
 private function createTitle ($page_id) {
  $title = str_replace('%p', (string)$page_id, $this->html_label_pagelink);
  $title = htmlspecialchars($title);
  return $title;
 }

}

?>