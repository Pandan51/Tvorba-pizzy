# Tvorba pizzy pomocí HTTP requestů a sessions

Obsah
- [index.php](#indexphp)
- [cart_handler.php](#cart-handlerphp)
- [view_cart.php](#view_cartphp)
- [order_handler.php](#order_handlerphp)



## index.php

<p> Řeší input uživatele.<br>
Uživatel má na výběr z jednoho základu
(Ketchup a Cream) + další dobrovolné možnosti</p>

<p>Uživatel může přidávát jen 1 kombinaci v čase,
ale může přidávát více než 1 zároveň</p>

<p>Přidáním se použije HTTP POST request k poslání dat z formuláře do cart_handler.php</p>

## cart-handler.php

<p>Řeší logiku ohledně košíku. 
Používá funkce, které se identifikují přes id
posílané přes POST requesty.</p>

<ol>
    <li><strong>"add"</strong><br>
    Přidávání pizzy přes úvodní stránku. 
    Tato funkce přidá pizzu a pokud už je tato
    kombinace přidána, přičte k dané kombinaci počet</li>
    <li><strong>"remove"</strong><br>
    Odstraní pizzu přes ID</li>
    <li><strong>"clearCart"</strong><br>
    Vyčistí košík přes session_unset()
    <li><strong>incrementQuantity</strong><br>
    Zvýší počet dané pizzy v košíku o 1</li>
    <li><strong>decrementQuantity</strong><br>
    Sníží počet dané pizzy o 1</li>
</ol>

## view_cart.php

### Košík
<p>Ukazuje košík s různými kombinacemi pizzy přidané přes index.php.
Zároveň můžeme zvýšit nebo snížit počet pizzy 
přes tlačítka vedle počtu. <br>
Tyto tlačítka posílají <strong>POST</strong> request 
na funkce v cart_handler.php 
<strong>(incrementQuantity a decrementQuantity)</strong>

</p>

<p>Lze také smazat celý košík přes tlačítko
<strong>Clear cart</strong></p>

### Formulář

<p>Musíme vědet kam poslat pizzu.
Proto je zde formulář, který získá tyto údaje. 
Tyto údaje se kontrolují v order_handler.php 
pomocí regexu a dalších filtrů.</p>
<p>Získání duše je povinný údaj.</p>

## order_handler.php

<p>Získá údaje z POST requestu, tyto údaje 
ověří a pokud splňují podmínky, 
košík se vyčístí a přesměruje na index.php, 
úvodní stránku, jinak se zpět přesměruje 
na view_cart.php</p>







