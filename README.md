# Detection of Specific Objects in Digital Images Leading to Scene Content Identification
author: Tereza Štanglová

Table of contents
------------------

  * [Dataset](#dataset)
  * [Overview](#overview)

Overview
--------
The main objective of my master thesis is to create a convolutional neural network for detection of specific objects in digital images.

Dataset
--------
The dataset I created is divided into two classes (target and non--target). Each image fits into one class. NSFW (target) images have classification class 1 and contain a pornography, naked women's breasts specifically. SFW (non-target) images have classification class 0.

<b>Caution</b>: CNN will mark as pornography only images that contain naked women's breasts. If you upload image with hardcore content you can get a wrong answer. It's because this project is only for academic purposes.

<!---
The main objective of my master thesis is to create a convolutional neural network for detection of specific objects in digital images. The dataset is divided into two classes (target and non--target) and each image has to fit into one class. Target images (class 1) should contain a pornography, naked women's breasts specifically, non-target images (class 0) should not. In the first part, basic features of convolutional neural networks (CNN) are presented. That includes structure of nets, description of layers and learning algorithm. The second part examines various architectures of CNNs. These architectures are implemented using CNTK framework. The most promising results were achieved with architecture with three and five convolutional layers and approximately eight thousand training samples. Also a web page was created for user testing. --->
