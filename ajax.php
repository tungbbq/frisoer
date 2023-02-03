<?php
$name = [$_POST] ?? '';
$day = [$_POST] ?? '';
$hour = [$_POST] ?? '';
$monday = [$_POST] ?? '';


$answer = '[
  {"name":"blocked", "day":"2023-01-31", "hour":9},  
  {"name":"", "day":"2023-02-01", "hour":9},
  {"name":"blocked", "day":"02022023", "hour":9},
  {"name":"", "day":"03022023", "hour":9},
  {"name":"blocked", "day":"04022023", "hour":9},
  {"name":"", "day":"31012023", "hour":10},  
  {"name":"", "day":"01022023", "hour":10},
  {"name":"blocked", "day":"02022023", "hour":10},
  {"name":"", "day":"03022023", "hour":10},
  {"name":"blocked", "day":"04022023", "hour":10},
  {"name":"", "day":"31012023", "hour":11},  
  {"name":"", "day":"01022023", "hour":11},
  {"name":"blocked", "day":"02022023", "hour":11},
  {"name":"", "day":"03022023", "hour":11},
  {"name":"blocked", "day":"04022023", "hour":11},
  {"name":"", "day":"31012023", "hour":12},  
  {"name":"blocked", "day":"01022023", "hour":12},
  {"name":"blocked", "day":"02022023", "hour":12},
  {"name":"", "day":"03022023", "hour":12},
  {"name":"blocked", "day":"04022023", "hour":12},
  {"name":"blocked", "day":"31012023", "hour":13},  
  {"name":"", "day":"01022023", "hour":13},
  {"name":"blocked", "day":"02022023", "hour":13},
  {"name":"blocked", "day":"03022023", "hour":13},
  {"name":"", "day":"04022023", "hour":13},
  {"name":"blocked", "day":"31012023", "hour":14},  
  {"name":"", "day":"01022023", "hour":14},
  {"name":"blocked", "day":"02022023", "hour":14},
  {"name":"", "day":"03022023", "hour":14},
  {"name":"", "day":"04022023", "hour":14},
  {"name":"", "day":"31012023", "hour":15},  
  {"name":"blocked", "day":"01022023", "hour":15},
  {"name":"blocked", "day":"02022023", "hour":15},
  {"name":"", "day":"03022023", "hour":15},
  {"name":"blocked", "day":"04022023", "hour":15},
  {"name":"", "day":"31012023", "hour":16},  
  {"name":"blocked", "day":"01022023", "hour":16},
  {"name":"", "day":"02022023", "hour":16},
  {"name":"blocked", "day":"03022023", "hour":16},
  {"name":"", "day":"04022023", "hour":16},
  {"name":"blocked", "day":"31012023", "hour":17},  
  {"name":"blocked", "day":"01022023", "hour":17},
  {"name":"", "day":"02022023", "hour":17},
  {"name":"blocked", "day":"03022023", "hour":17},
  {"name":"", "day":"04022023", "hour":17}
  
]';
echo $answer;
