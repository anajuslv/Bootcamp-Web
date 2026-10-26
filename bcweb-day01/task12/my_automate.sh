#!/bin/bash

tasks=$1
day=$(printf "%02d" "$2")

mkdir -p "day$day"

for ((i = 1; i <= tasks; i++)); do
   task=$(printf "%02d" "$i")
   mkdir -p "day$day/task$task"
done