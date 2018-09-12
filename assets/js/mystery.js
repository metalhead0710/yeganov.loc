
!(function($) {
  'use strict';

  var Mystery = {
    options: {},

    init: function(options, root) {

      this.root = $(root);
      this.options = $.extend({}, this.options, options);

      // Bind handlers
      this.bindHandlers();
    },

    bindHandlers: function() {
      this.hello();
    },

    hello: function() {
      console.log(`
    Вітаю, ти добралася сюди. 
    Значить ще не всьо потєряно, і ти на правильному шляху. Можеш поколупати цей скрипт, але він обфусцир... обфуксован... Блять. кроч, той хрущ зробив його нечитабельним. 
    Поговори зі мною, мені так самотньо. запусти ф-цію initTalk(). Просто пишеш сюди initTalk(); і пиздячиш по ентеру)`);
    }

  };

  App.Page.Mystery = function(options, root) {
    root = root || $('body');

    root = $(root)[0];
    if (!$.data(root, '_Mystery')) {
      $.data(root, '_Mystery', Object.create(Mystery).init(options, root));
    }
    return $.data(root, '_Mystery');
  };
})(jQuery);
let initTalk = function() {
  console.log('Поговорити то я хочу, одначе, з секурних причин мене позбавили вух, тому там має вікошко з діалогом вискочити, туди і пиши');
  var names = ['Натал', 'Натал Какіт', 'Пташка'];
  do {
    console.log(`Мав на увазі твоє "справжнє ім'я"`);
    var name = prompt('Як тебе звати');
    var tf = names.indexOf(name);
  }
  while (tf === -1);

  console.log(`Ок ${name}, з цим розібралися, далі скажи мені: яка твоя найулюбленіша тварина?`);
  do {
    var animals = ["Кіт", "кіт"];
    var animal = prompt();
    var tf = animals.indexOf(animal);
  } while (tf === -1);
  console.log("Це було нетяжко, правда?");
  //TODO: change the domain
  console.info('Тепер перейди сюди http://yeganov.loc:81/natal/LkXunYDhoUAYxNrQ3OnImdNKjaTMMEbOd5pVtkDpRpfwvrmFHskt2Nv68AF913XhaB0q0DqVbwFDaYXGwYGzrQhVj67IlT6iTlhKbmrOcgBT11gnHa9ilYe3LOxRveJsV1rz5Z10VN2GzZRQI45bwIbIZSX6amJsDNbuO3l3nqIWRsSyVnIw6Sucswc26U6pa1dd6NuMMZUecP7CJRY4rOz1CHcPyLqPdWq88aE65Zri55vVysG85djhd5Hdr7Q');
  console.log("А я на цьому откланяюсь.");
}