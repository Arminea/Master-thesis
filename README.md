# Detection of Specific Objects in Digital Images Leading to Scene Content Identification
author: Tereza Štanglová

<i> Readme in progress </i>

Table of contents
------------------

  * [Overview](#overview)
  * [Dataset](#dataset)
  * [Data preprocessing](#data-preprocessing)

Overview
--------
The main objective of my master thesis is to create a convolutional neural network for detection of specific objects in digital images. <a href="https://docs.microsoft.com/en-us/cognitive-toolkit/" target="_blank">The Microsoft Cognitive Toolkit</a> (CNTK) was used for data classification. Project was developed in CNTK version 2.0 Beta 11. So it's possible that some of the code here is outdated.

You can try to upload your own image at my page <a href="http://147.228.64.42/pdetect/" target="_blank">http://147.228.64.42/pdetect/</i>.

Dataset
--------
The dataset I created is divided into two classes (target and non--target). Each image fits into one class. NSFW (target) images have classification class 1 and contain a pornography, naked women's breasts specifically. SFW (non-target) images have classification class 0.

<b>Caution</b>: CNN will mark as pornography only images that contain naked women's breasts. If you upload image with hardcore content you can get a wrong answer. It's because this project is only for academic purposes.

Data preprocessing
------------------

<!---
The main objective of my master thesis is to create a convolutional neural network for detection of specific objects in digital images. The dataset is divided into two classes (target and non--target) and each image has to fit into one class. Target images (class 1) should contain a pornography, naked women's breasts specifically, non-target images (class 0) should not. In the first part, basic features of convolutional neural networks (CNN) are presented. That includes structure of nets, description of layers and learning algorithm. The second part examines various architectures of CNNs. These architectures are implemented using CNTK framework. The most promising results were achieved with architecture with three and five convolutional layers and approximately eight thousand training samples. Also a web page was created for user testing. --->
