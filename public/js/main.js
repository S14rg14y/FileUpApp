let dropArea = document.getElementById('drop-area');

let filesDone = 0;
let filesToDo = 0;
let progressBar = document.getElementById('progress-bar');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
	dropArea.addEventListener(eventName, preventDefaults, false)
});

function preventDefaults(e) {
	e.preventDefault();
	e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
	dropArea.addEventListener(eventName, highlight, false)
});

['dragleave', 'drop'].forEach(eventName => {
	dropArea.addEventListener(eventName, unhighlight, false)
});

function highlight(e) {
	dropArea.classList.add('highlight');
}
function unhighlight(e) {
	dropArea.classList.remove('highlight');
}
dropArea.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
	let dt = e.dataTransfer;
	let files = dt.files;
	handleFiles(files);
}
function handleFiles(files) {
	([...files]).forEach(uploadFile);
	initializeProgress(files.length);
}

function initializeProgress(numfiles) {
	progressBar.value = 0
	filesDone = 0
	filesToDo = numfiles
  }
  function progressDone() {
	filesDone++
	progressBar.value = filesDone / filesToDo * 100
  }
function uploadFile(file) {
	let url = '/fileupload/public/';
	let formData = new FormData();
	formData.append('userFile', file);
	fetch(url, {
		method: 'POST',
		body: formData
	})
		.then(progressDone)
		.catch(() => { console.log("error"); });
}

function uploadFil(file) {
	var url = '/fileupload/public/';
	var xhr = new XMLHttpRequest();
	var formData = new FormData();
	xhr.open('POST', url, true);
	xhr.addEventListener('readystatechange', function (e) {
		if (xhr.readyState == 4 && xhr.status == 200) {
			console.log("all ok");
		}
		else if (xhr.readyState == 4 && xhr.status != 200) {
			console.log("not ok");
		}
	});
	formData.append('userFile', file);
	xhr.send(formData);
}