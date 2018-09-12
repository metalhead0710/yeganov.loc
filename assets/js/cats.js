console.log('Додумалась) вже зовсім трохи лишилось. Тут запусти ф-цію continueTalk()');
let continueTalk = function() {
  do {
    console.log(`Отож...`);
    var oddCat = prompt('Який же з пхрів зайвий?');
  }
  while (oddCat != 6);

  console.log(`Ок, а чому? Назви причину одним словом`);
  do {
    var reasons = ["Вуса", "вуса", "вюса", "Вюса"];
    var reason = prompt('Причина?');
    var tf = reasons.indexOf(reason);
  } while (tf === -1);
  console.log("Урррраааааа. Нарешті ця хрінь закінчилася і ти зможеш побачити, що цей ушльопок там тобі набажав.");
  //TODO: change the domain
  console.info('Він то положив отут http://yeganov.loc:81/natal/TtsmzKkg8hi5ZIE2t3dZ3ziUIEH4bG1JHT3vXDE90VQwKFMWSwQvZfw0wiprMEmfWOpEcnF66UOt1kBJpKKW3KzXvhsQBgmDlTAfFdFhJzCxUrIc9fyDo8Atv1WhHXxAfbHEGnpe0WN6MuCwwAmgP0xe7TpQXiREYdXVGT6v8cCsY9ItZenuT5boaTd7woWe8AQpCaZduB98RzPSS4Sv52XH9TsjUUoi9G8bw2OiYUlp8YBa10gWplVMfk8xfPw');
  console.log("Все папа. В мене багато роботи ше, а часу мало, бо крон зітре мене опівночі");
}