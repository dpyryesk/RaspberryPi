#!/bin/bash -e

echo "========================" >> tts-log.txt
date >> tts-log.txt
echo $1 >> tts-log.txt
echo "message from: '$2'" >> tts-log.txt
echo $3 >> tts-log.txt

echo "message from '$2'" | festival --tts

echo $1 | festival --tts

echo "Pi said: '$1'"
