function formatCurrency() {
    var element = document.getElementById('price');
    var price = element.value;
    

    price = price + '';
    price = parseInt(price.replace(/[\D]+/g, ''));
    price = price + '';
    price = price.replace(/([0-9]{2})$/g, ",$1");

    if (price.length > 6) {
        price = price.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
    }

    element.value = price;
    if(price == 'NaN') element.value = '';
    
}