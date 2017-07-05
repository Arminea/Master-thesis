"""
 ---------------------------------------

 	Master thesis, 2016/2017
 	Tereza Stanglova, A14N0115P

 Script for creating a map file for ImageReader
 https://github.com/Microsoft/CNTK/wiki/BrainScript-Image-reader
---------------------------------------
"""

import sys
import os
import getopt
import unicodedata
import random
import datetime as dt 

from PIL import Image
from random import randint

configDirName 	= 'config'					# config folder
logDirName		= 'log'
imageFormats 	= ('.jpg', '.jpeg', '.png') # allowed file extensions

# unindent does not match any outer indentation level - problem s taby

def edit_filename(image):
	"""
	Function edits a name of file. The space is replaced with underscore character. At the end of the filename is randomly generated number.
	Args:
		image: an image which will be renamed

	Returns:
		renamed image
	"""
	name, ext = os.path.splitext(image)
	newName = name.replace(' ', '_')		# for file names without spaces
	newName = newName.decode('unicode_escape').encode('ascii','ignore') # eliminate all characters that are not ascii

	if newName == '':
		newName = str(random.randint(10000, 100000000)) + ext
		return newName
	
	if newName != name:
		#print name + ' ' + newName
		newName = newName + str(random.randint(10000, 100000000)) + ext
		return newName

	return image


def write_file(directory, f, imageClass, logFile):
	"""
	Function writes paths of images into a text file.
	Line format: path_to_image<tab>class_of_image

	Args:
		directory: 	directory of all target/non-target images
		f: 			map file
		imageClass: class of image
		logFile: 	log file

	Raises:
		IOError: if file is not an image
	"""
	allFiles = os.listdir(directory)
	for image in allFiles:
		newName = edit_filename(image)
		if newName != image:
			os.rename(os.path.join(directory, image), os.path.join(directory, newName))
			#print image + ' ' + newName
			image = newName
		
		path = os.path.join(directory, image)
		string = path + '\t' + str(imageClass) + '\n'
		#print path
		try:
			Image.open(path)

			filename, extension = os.path.splitext(path)
			if extension.lower() not in imageFormats:
				mess = 'ERROR: Image extension is not png, jpg or jpeg. PATH: ' + path + '\n'
				logError(logFile, mess)
			else:	
				f.write(string.encode('utf8'))
		except IOError:
			mess = 'ERROR: File is not an image. PATH: ' + path + '\n'
			logError(logFile, mess)


def ZuliDoTheThing(mapFileFullPath, targetDir, nontargetDir, logFile):
	"""
	Function creates a map file with paths to target and non-target images.

	Args:
		mapFileFullPath: 	path to map file
		targetDir: 			directory with target images
		nontargetDir: 		directory with non-target images
		logFile: 			log file
	"""
	print ("Creating a map file...")

	f = open(mapFileFullPath, 'w+')

	write_file(targetDir, f, 1, logFile)
	write_file(nontargetDir, f, 0, logFile)

	f.close()

	print ("Map file saved.\n")


def logError(logFile, message):
	"""
	Function writes a message into log file.

	Args:
		logFile: log file
		message: log message
	"""
	log = open(logFile, 'a+')
	log.write(message)
	log.close()


def main(argv):
	"""
	Main function for argument parsing
	"""
	try:
		opts, args = getopt.getopt(argv,"h:t:n:m:", ["help", "target=", "nontarget=", "method="])
	except getopt.GetoptError:
		print ('Wrong number of arguments. Please, run this script with parameter --h or --help for more information.')
		sys.exit(2)

	for opt, arg in opts:
		if opt in ('-h', '--help'):
			help = "-------------------------------\n"
			help += "Master thesis\n"
			help += "Tereza Stanglova, A14N0115P\n"
			help += "2016/2017\n"
			help += "-------------------------------\n\n"
			help += "This script will create a map file for CNTK ImageReader.\nFor more information you can read an ImageReader manual https://github.com/Microsoft/CNTK/wiki/BrainScript-Image-reader\n\n"
			help += "Parameters of this script: \n ------------------------------- \n -t path to directory with target images \n -n path to directory with non-target images \n -m method (train or test) \n\n Command example: \n python ImagePreprocessing.py -t /data/train_target -n /data/train_nontarget -m train "
			print (help)
			sys.exit(2)
		elif opt in ('-t', '--target'):
			targetDir = arg
			
		elif opt in ('-n', '--nontarget'):
			nontargetDir = arg
			
		elif opt in ('-m', '--method'):
			method = arg

	if not os.path.isdir(targetDir) or not os.path.isdir(nontargetDir):
		print ('One or both of the paths are not directories.')
		sys.exit(1)

	rootDir = os.path.dirname(os.path.abspath(__file__)) # directory of the script being run

	logFile = os.path.join(rootDir, logDirName, dt.datetime.today().strftime("%Y-%m-%d_%H-%M-%S") + '_ImagePreprocessing.log')

	mapFile = method + '_map.txt'
	mapFileFullPath = os.path.join(rootDir, configDirName, mapFile)
	#print (mapFileFullPath)

	ZuliDoTheThing(mapFileFullPath, targetDir, nontargetDir, logFile)

if __name__ == "__main__":
	main(sys.argv[1:])	

# python ImagePreprocessing.py -t C:\Users\tstanglova\Downloads\cntk\data\target -n C:\Users\tstanglova\Downloads\cntk\data\nontarget -m train
# python ImagePreprocessing.py -t /share/data/cntk/test_target -n /share/data/cntk/test_nontarget -m test
# python ImagePreprocessing.py -t /share/data/cntk/train_target -n /share/data/cntk/train_nontarget -m train