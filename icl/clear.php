<?php

if (file_exists('chat.txt')) {
	unlink('chat.txt');
	echo "Bebras sumedziotas";
} else {
	echo "Nera Bebro";
}