/**
 * Number.prototype.format(n, x)
 * 
 * @param integer n: length of decimal
 * @param integer x: length of sections
 */
Number.prototype.format = function (n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
    /*    
    1234..format();           // "1,234"
    12345..format(2);         // "12,345.00"
    123456.7.format(3, 2);    // "12,34,56.700"
    123456.789.format(2, 4);  // "12,3456.79"
    */
};

/**
 * Number.prototype.format(n, x, s, c)
 * 
 * @param integer n: length of decimal
 * @param integer x: length of whole part
 * @param mixed   s: sections delimiter
 * @param mixed   c: decimal delimiter
 */
Number.prototype.format = function (n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));

    /*
    12345678.9.format(2, 3, '.', ',');  // "12.345.678,90"
    123456.789.format(4, 4, ' ', ':');  // "12 3456:7890"
    12345678.9.format(0, 3, '-');       // "12-345-679"
    */
};

function countDecimals(value) {
    var temp = Math.floor(value)
    if (temp === value)
        return 0;
    else if (value != '') {
        var str = value - temp;

        // var temp = value.toString().split(".")[1].length || 0; 
        temp = str.length;
        return temp;
    }
}

function currencyStrToDouble(currencyStr) {
    return Number(currencyStr.replace(/[^0-9.-]+/g, ""));
}

function cleanCurrencyStr(currencyStr) {
    return currencyStr.replace(/[^0-9.,-]+/g, "");
}


function validateLoginForm() {
    var customer_name = $('.validate-input input[name="customer_name"]');
    var customer_phone = $('.validate-input input[name="customer_phone"]');
    var customer_email = $('.validate-input input[name="customer_email"]');

    var check = true;

    if (validateText(customer_name) == false) check = false;
    if (validatePhone(customer_phone) == false) check = false;
    if (validateEmail(customer_email) == false) check = false;

    return check;
}

function validatePaymentForm(ref_2_optional) {
    var customer_name = $('.validate-input input[name="customer_name"]');
    var customer_phone = $('.validate-input input[name="customer_phone"]');
    var customer_email = $('.validate-input input[name="customer_email"]');
    var reference_order = $('.validate-input input[name="INVOICENO"]');
    var customer_id = $('.validate-input input[name="customer_id"]');
    var PAYMENTFOR = $('.validate-input select[name="PAYMENTFOR"]');
    var AMOUNT_SHOW = $('.validate-input input[name="AMOUNT_SHOW"]');

    // hide all validate alert first
    hideValidate(customer_name);
    hideValidate(customer_phone);
    hideValidate(customer_email);
    hideValidate(reference_order);
    hideValidate(customer_id);
    hideValidate(PAYMENTFOR);
    hideValidate(AMOUNT_SHOW);


    var check = true;

    if (validateText(customer_name) == false) check = false;
    if (validatePhone(customer_phone) == false) check = false;
    if (validateEmail(customer_email) == false) check = false;
    if (validateText(reference_order) == false) check = false;

    if (ref_2_optional == 'N') //N=NotOptional, Y=Optional
        if (validateText(customer_id) == false) check = false; //optional

    if (validateSelect(PAYMENTFOR) == false) check = false;
    if (validateMoney(AMOUNT_SHOW) == false) check = false;

    return check;
}

function validateText(input) {
    if ($(input).val().trim() == '') {
        // alert( $(input).attr("name") + ' is empty!');
        showValidate(input);
        return false;
    }
    else {
        return true;
    }
}

function validateEmail(input) {
    if ($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
        showValidate(input);
        return false;
    }
    else
        return true;
}

function validatePhone(input) {
    if ($(input).val().trim().match(/^[+]?[\s./0-9]*[(]?[0-9]{1,4}[)]?[-\s./0-9]*$/g) == null) {
        showValidate(input);
        return false;
    }
    else
        return true;
}

function validateSelect(input) {
    if ($(input).val().trim() == 'Select') {
        showValidate(input);
        return false;
    }
    else
        return true;
}

function validateMoney(input) {
    var regex = /^[1-9]\d*(((,\d{3}){1})?(\.\d{0,2})?)$/;
    var numStr = $(input).val().trim();
    if (regex.test(numStr) == false) {
        showValidate(input);
        return false;
    }
    else
        return true;
}

function showValidate(input) {
    var thisAlert = $(input).parent();

    $(thisAlert).addClass('alert-validate');
}

function hideValidate(input) {
    var thisAlert = $(input).parent();

    $(thisAlert).removeClass('alert-validate');
}