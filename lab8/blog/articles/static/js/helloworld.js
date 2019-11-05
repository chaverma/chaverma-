var groupmates = [{"name": "Дима","group": "бап-1851","age": 22,"marks": [4, 3, 5, 5, 4]},
{"name": "Анна","group": "бап-1851","age": 20,"marks": [3, 2, 3, 4, 3]},
{"name": "Алан","group": "бап-1854","age": 21,"marks": [3, 5, 4, 3, 5]},
{"name": "Ксюша","group": "бап-1853","age": 20,"marks": [5, 5, 5, 4, 5]}];
console.log(groupmates);
var filter = "бап-1853"//название группы
if (filter == "..") {
  console.log('текущий фильтр: нет')
}else{
  console.log('текущий фильтр: '+filter)
}

var rpad = function(str, length) {
    // js не поддерживает добавление нужного количества символов
    // справа от строки то есть аналога ljust из языка Python здесь нет
    str = str.toString(); // преобразование в строку
    while (str.length < length)
        str = str + ' '; // добавление пробела в конец строки
    return str; // когда все пробелы добавлены, возвратить строку
};
var printStudents = function(students){
    console.log(
        rpad("Имя студента", 15),
        rpad("Группа", 8),
        rpad("Возраст", 8),
        rpad("Оценки", 20)
    );
    // был выведен заголовок таблицы
    for (var i = 0; i<=students.length-1; i++){
      if (filter == students[i]['group'] || filter == "..") {
        // в цикле выводится каждый экземпляр студента
        console.log(
            rpad(students[i]['name'], 15),
            rpad(students[i]['group'], 8),
            rpad(students[i]['age'], 8),
            rpad(students[i]['marks'], 20));
      }
    }
    console.log('\n'); // добавляется пустая строка в конце вывода
};
printStudents(groupmates);
