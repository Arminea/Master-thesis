#!/opt/anaconda3/envs/cntk-py35/bin/python

"""
 ---------------------------------------

 	Master thesis, 2016/2017
 	Tereza Stanglova, A14N0115P

 Script for image classification via CNTK DNN model.
---------------------------------------
"""

import sys
sys.path.append('/opt/anaconda3/envs/cntk-py35/bin/python');

import os
import string
import random
import cgi
import json
import time
from PIL import Image 
import numpy as np
import cntk as ct
from cntk import load_model

# ================ CONSTANTS =====================
# Model name
MODEL = "model.dnn"
# Directory for uploaded images
UPLOAD_DIR = "/pdetect/upload/"

# ================ FUNCTIONS =====================

# Removes trancparency layer.
def remove_transparency(im, bg_colour=(255, 255, 255)):
	# Only process if image has transparency (http://stackoverflow.com/a/1963146)
	if im.mode in ('RGBA', 'LA') or (im.mode == 'P' and 'transparency' in im.info):
		alpha = im.convert('RGBA').split()[-1]
		bg = Image.new("RGBA", im.size, bg_colour + (255,))
		bg.paste(im, mask=alpha)
		#print ("Transparency removed")
		return bg
	else:
		return im

# Converts images in L mode (8-bit pixels, black and white) or P mode (8-bit pixels, mapped to any other mode using a color palette) to RBG mode (3x8-bit pixels, true color).
def LPmode2RGB(im):
	if im.mode == 'L' or im.mode == 'P':
		im = im.convert('RGB')
	return im


def debug_cntk_outputnodes():
	"""
	DEBUG function which prints all output nodes of model made in BrainScript. The node of interest is the last index.
	For example:
		Index 0 for outpus: ce.
		Index 1 for output: evalNodes.
		Index 2 for output: o1.
	"""
	z = load_model(MODEL)
	print ("Load complete.");
	for index in range(len(z.outputs)):
		print("Index {} for output: {}.".format(index, z.outputs[index].name))


def cntk_prediction(pathToImage):
	"""
	Fuction has following steps:
	- open the image
	- alter the image (change color mode, resize)
	- convert image to array, subtract the mean, roll axis
	- load model
	- pass on the image to model fo classification
	- return a result of classification or an error

	Args:
		pathToImage: server path of image

	Returns:
		top_class: the result of classification (1 - target class, 0 - non-target class, -1 - error)
	"""
	top_class = -1
	size = 224, 224

	try:
		im = Image.open(pathToImage)
		im = remove_transparency(im)
		im = LPmode2RGB(im) # black and white images
		im = im.resize(size) # PIL.Image.NEAREST resampling

		rgb_image = np.asarray(im, dtype=np.float32) - 128
		bgr_image = rgb_image[..., [2, 1, 0]]
		pic = np.ascontiguousarray(np.rollaxis(bgr_image, 2))

		z = load_model(MODEL)
		z_out = ct.combine([z.outputs[3].owner])
		y = ct.ops.softmax(z_out)
		predictions = np.squeeze(y.eval({y.arguments[0]:[pic]}))
		top_class = np.argmax(predictions)
	except Exception:
		# Nothing will be done in the case of exception. Function will return -1 value. 
		pass

	return top_class


def save_image(fileitem):
	"""
	Function saves the original image to upload directory on server.

	Args:
		fileitem: uploaded image

	Returns:
		full_path: server path of uploaded image (after saving)
	"""
	document_root = os.environ["DOCUMENT_ROOT"]
	fn = os.path.basename(fileitem.filename)
	full_path = document_root + UPLOAD_DIR + fn
	open(full_path, 'wb').write(fileitem.file.read())
	return full_path



def filename_generate(image_class, size=12, chars=string.ascii_uppercase + string.ascii_lowercase + string.digits):
	"""
	Function generates a new filename with class indication. New file name is a combination of upper and lower case letters and numbers.
	Filename format: <current date>_<generated string>_<predicted class>

	Args:
		image_class: predicted class
		size: size of generated filename
		chars: allowed characters (uppercase, lowercase, digits)
	Returns:
		new_filename: new generated filename
	"""
	new_filename = time.strftime("%d-%m-%Y_")
	new_filename = new_filename + ''.join(random.choice(chars) for _ in range(size))
	new_filename = new_filename + "_P" + str(image_class)
	return new_filename


def filename_split(path):
	"""
	Function splits path to file to directory, filename and extension.

	Args:
		path: server path of image
	Returns:
		directory, filename, extension
	"""
	directory = os.path.dirname(path)
	filename, extension = os.path.splitext(os.path.basename(path))
	return directory, filename, extension

# Renames uploaded image.
def file_rename(old_path, image_class):
	"""
	Function renames an image. Safe precaution against file name collision.

	Args:
		old_path: old server path of image
		image_class: predicted class

	Returns:
		new_path: new server path of image
	"""
	directory, filename, extension = filename_split(old_path)
	new_filename = filename_generate(image_class)
	new_path = os.path.join(directory, new_filename + extension)
	os.rename(old_path, new_path)
	return new_path

def getTranslations(lang):
	translations = dict()

	if lang == 'cz':
		translations['TARGET_CLASS_RESULT'] = "Nahraný obrázek obsahuje hledané objekty. Může se jednat o pornografii."
		translations['NON_TARGET_CLASS_RESULT'] = "Nahraný obrázek neobsahuje hledané objekty. Nejedná se o pornografii."
		translations['UNEXPECTED_ERROR'] = "Při klasifikaci obrázku došlo k neočekávané chybě."
		translations['NOT_FILE_ERROR'] = "Nahraný objekt není soubor."
	else:
		translations['TARGET_CLASS_RESULT'] = "Image was evaluated as target class - pornography."
		translations['NON_TARGET_CLASS_RESULT'] = "Image was evaluated as non-target class - not pornography."
		translations['UNEXPECTED_ERROR'] = "An unexpected error occurred while classifying the image."
		translations['NOT_FILE_ERROR'] = "Uploaded object is not a file."

	return translations

if __name__ == "__main__":
	"""
	Main function which gets values from cgi field storage, calls function for classification and passes on the result to user.
	"""
	print ("Content-type: application/json\n\n")

	# storage of alll form values
	form = cgi.FieldStorage(keep_blank_values=True)
	# image input field 
	fileitem = form['inputImageUpload']
	# lang hidden input field
	lang = form['hiddenLangUpload'].value
	# array of translated strings
	translations = getTranslations(lang)

	if fileitem.file:
		full_path = save_image(fileitem)
		top_class = cntk_prediction(full_path)
		full_path = file_rename(full_path, top_class)

		if top_class == 1:
			response = {'server_filepath': full_path, 'predicted_class': str(top_class), 'message': translations['TARGET_CLASS_RESULT']}
		elif top_class == 0:
			response = {'server_filepath': full_path, 'predicted_class': str(top_class), 'message': translations['NON_TARGET_CLASS_RESULT']}
		else:
			response = {'server_filepath': full_path, 'predicted_class': str(top_class), 'message': translations['UNEXPECTED_ERROR']}
		print(json.JSONEncoder().encode(response))
	else:
		top_class = -1
		response = {'server_filepath': full_path, 'predicted_class': str(top_class), 'message': translations['NOT_FILE_ERROR']}
		print(json.JSONEncoder().encode(response))