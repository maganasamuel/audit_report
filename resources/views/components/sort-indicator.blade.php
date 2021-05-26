@props(['sortColumn', 'columnName'])

@php
$sortClasses = [
    '' => 'fa-sort',
    'asc' => 'fa-sort-up',
    'desc' => 'fa-sort-down',
];
@endphp

&nbsp;
<i
  class="fa fa-lg {{ $sortColumn['name'] == $columnName ? $sortClasses[$sortColumn['direction']] : 'fa-sort' }}">&nbsp;</i>
