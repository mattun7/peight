document.addEventListener('DOMContentLoaded', function () { //①

    var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0); //②
  
    if ($navbarBurgers.length > 0) {
  
      $navbarBurgers.forEach(function ($el) {
        $el.addEventListener('click', function () { //③
  
          var target = $el.dataset.target; //④
          var $target = document.getElementById(target); //④
  
          $el.classList.toggle('is-active'); //⑤
          $target.classList.toggle('is-active'); //⑤
  
        });
      });
    }
  });

function $(id) {
    return document.getElementById(id);
}

function getSysDate() {
    var dt = new Date();
    var y = dt.getFullYear();
    var m = ("00" + (dt.getMonth()+1)).slice(-2);
    var d = ("00" + dt.getDate()).slice(-2);
    var result = y + "-" + m + "-" + d;
    return result;
}

function setOption(id, value, text) {
    let option = document.createElement('option');
    option.value = value;
    option.text = text;
    $(id).appendChild(option);
}

class DbName {
  static id(host) {
    return host === 'localhost' ? 'ID' : 'id';
  }

  static pet_type_id(host) {
    return host === 'localhost' ? 'PET_TYPE_ID' : 'pet_type_id';
  }
  
  static color(host) {
    return host === 'localhost' ? 'COLOR' : 'color';
  }
  
  static instrumentantion_days(host) {
    return host === 'localhost' ? 'INSTRUMENTANTION_DAYS' : 'instrumentantion_days';
  }
  
  static weight(host) {
    return host === 'localhost' ? 'WEIGHT' : 'weight';
  }
}