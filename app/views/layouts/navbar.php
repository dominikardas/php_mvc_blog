<nav class="l-navbar">
    <ul>
        <?php

        /**
         * Dynamically generate the navigation menu from a JSON file located in the root folder
         */
        $file = ROOT . DS . 'navigation.json';
        $str = file_get_contents($file);
        $json = json_decode($str, true);

        /**
         * Recursively generate each item and its sub items
         */
        function parseMenu($menu, $isSubmenu = false) {
            
            foreach ($menu as $category => $value) {

                if (isLoggedIn()  && $menu[$category]['hideIfLogged'] ||
                    !isLoggedIn() && $menu[$category]['loggedIn'] ||
                    !isAdmin()    && $menu[$category]['isAdmin'])
                    continue;
                
                // If the menu contains a sub menu, recursively call this function
                if ($menu[$category]['sub'] != null) {
                    
                    echo '<li>';
                    echo '<span>' . $category . '</span>';
                    echo '<ul class="l-navbar_subcat">';
                    parseMenu($menu[$category]['sub'], true);
                    echo '</ul>';
                    echo '</li>';
                }
                // Otherwise just display the single item
                else {
                    echo sprintf('<li class="l-navbar-item"><a href="%s">%s</a></li>', $menu[$category]['href'], $category);
                }               
                
                echo '</li>';
            }
        }

        parseMenu($json);

        echo (currentLoggedUser() != null) ? '<li>' . currentLoggedUser() . '</li>' : '';
        ?>
    </ul>
</nav> 