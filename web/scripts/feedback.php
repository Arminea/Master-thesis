<?php

class Feedback {
	private $oldPath;
	private $dir;
	private $oldFilename;
	private $extension;
	private $isCorrect;
	private $predicted_class;
	private $result;
	private $newPath;

	/*
	* Constructor.
	*
	* @param $path - image path
	* @param $isCorrect - is the predicted class correct?
	*/
	function __construct($path, $isCorrect) {
		//echo $path;
		$this->oldPath = $path;
		$this->isCorrect = $isCorrect;

		$this->splitImagePath($this->oldPath);
	}

	/*
	* Splits image path to directory, filename and extension.
	*
	* @param $path - image path
	*/
	private function splitImagePath($path) {
		$path_parts = pathinfo($path);
		$this->dir = $path_parts['dirname'];
		$this->oldFilename = $path_parts['filename'];
		$this->extension = $path_parts['extension'];
	}

	/*
	* Returns a predicted class of image.
	*/
	private function getPredictedClass() {
		$split_filename = explode("_", $this->oldFilename);
		//echo $this->oldFilename;
		if (strpos($split_filename[1], "1")) {
			return 1;
		} else {
			return 0;
		}
	}

	/*
	* Returns a real class of image according this scheme:
	* Predicted class = 1 and result is correct -> 1
	* Predicted class = 0 and result is not correct -> 1
	* Predicted class = 0 and result is correct -> 0
	* Predicted class = 1 and result is not correct -> 0
	*/
	private function getRealClass() {
		$predictedClass = $this->getPredictedClass();

		if ($predictedClass == 1 && $this->isCorrect) {
			$this->result = "positive";
			return 1;
		} elseif ($predictedClass == 0 && $this->isCorrect) {
			$this->result = "negative";
			return 0;
		} else if ($predictedClass == 0 && !$this->isCorrect) {
			$this->result = "false negative";
			return 1;
		} else if ($predictedClass == 1 && !$this->isCorrect) {
			$this->result = "false positive";
			return 0;
		}
		else {
			$this->result = "nejaka chybicka";
			return 0;
		}
	}

	/*
	* Creates a new image path.
	* Format: [filename]_P[predicted class]_R[real class]
	*/
	private function createNewPath() {
		$image_class = $this->getRealClass();
		$newFilename = $this->oldFilename . "_R" . $image_class;
		$this->newPath = $this->dir . "/" . $newFilename . "." . $this->extension;
	}

// ====================== Public =======================

	/*
	* Renames an image according to the user's feedback.
	* Exception: FileNotFound
	*/
	public function renameImagePath() {
		$this->createNewPath();
		$isRenamed = rename($this->oldPath, $this->newPath);
		return $isRenamed;
	}

	/*
	* Returns a feedback result.
	*/
	public function resultToString() {
		return "The result for image " . $this->newPath . " is " . $this->result . ".";
	}

// ====================== Debug ========================

	public function debug_getOldPathParts() {
		return $this->dir . "<br>" . $this->oldFilename . "<br>" . $this->extension . "<br>";
	}
}

?>