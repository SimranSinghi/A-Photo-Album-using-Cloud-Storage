# A-Photo-Album-using-Cloud-Storage
Developed a photo-album application on Dropbox.

use Dropbox to store the photos and you need to be able to delete photos. Your task is to modify your album.php script in your project6 directory to support the following operations:

Provide a form to upload a new image (a *.jpg) on Dropbox. Look at the class slides for a PHP example that handles uploads.
A display window that lists the names of the images in your Dropbox directory. For each image name you have a link that, when you click it, it downloads and displays the image in the image section. Each image name also has a button to delete this image from the Dropbox storage.
An image section that displays the current image. This time a photo will be downloaded inside the image directory before it's displayed. Can be the same image file.
Note that your program should be written in PHP using Dropbox for HTTP Developers (Links to an external site.). Don't use any additional PHP libraries or any other language.

I have provided PHP code for listing a directory, and uploading and downloading a file. You need to write a PHP function to delete a file. It will be similar to the other functions. Look at the dropbox /files/delete_v2 (Links to an external site.) curl call.
