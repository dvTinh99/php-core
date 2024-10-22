<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>XMLHttpRequestUpload test</title>
    <link rel="stylesheet" href="xhrupload_test.css" />
    <script src="xhrupload_test.js"></script>
  </head>
  <body>
    <main>
      <h1>Upload a file</h1>
      <p>
        <label for="file">File to upload</label><input type="file" id="file" multiple/>
      </p>
      <p>
        <progress />
      </p>
      <p>
        <output></output>
      </p>
      <p>
        <button disabled id="abort">Abort</button>
      </p>
    </main>
  </body>
</html>
<script>
addEventListener("DOMContentLoaded", () => {
  const fileInput = document.getElementById("file");
  const progressBar = document.querySelector("progress");
  const log = document.querySelector("output");
  const abortButton = document.getElementById("abort");

  fileInput.addEventListener("change", (event) => {
    
    let listRequest = []
    for (let index = 0; index < fileInput.files.length; index++) {
      const element = fileInput.files[index];
      const request = uploadExcel(element, progressBar, abortButton, index)

      listRequest.push(request);
    }
    Promise.all(listRequest).then((values) => {
      console.log('done all');
    });
  });
});

async function uploadExcel(element, progressBar, abortButton, index = 0) {
  // Link abort button
  abortButton.addEventListener(
    "click",
    () => {
      xhr.abort();
    },
    { once: true },
  );

  const xhr = new XMLHttpRequest();
  //xhr.timeout = 20000; // 2 seconds
  // When the upload starts, we display the progress bar
  xhr.upload.addEventListener("loadstart", (event) => {
    progressBar.classList.add("visible");
    progressBar.value = 0;
    progressBar.max = event.total;
    console.log("Uploading (0%)…" + index);
    abortButton.disabled = false;
  });

  // Each time a progress event is received, we update the bar
  xhr.upload.addEventListener("progress", (event) => {
    progressBar.value = event.loaded;
    console.log(`${index}Uploading (${(
      (event.loaded / event.total) *
      100
    ).toFixed(2)}%)…`);
  });

  // When the upload is finished, we hide the progress bar.
  xhr.upload.addEventListener("loadend", (event) => {
    progressBar.classList.remove("visible");
    if (event.loaded !== 0) {
      console.log(index + "Upload finished.");
    }
    abortButton.disabled = true;
  });

  // In case of an error, an abort, or a timeout, we hide the progress bar
  // Note that these events can be listened to on the xhr object too
  function errorAction(event) {
    progressBar.classList.remove("visible");
    console.log(`${index}Upload failed: ${event.type}`);
  }
  xhr.upload.addEventListener("error", errorAction);
  xhr.upload.addEventListener("abort", errorAction);
  xhr.upload.addEventListener("timeout", errorAction);

  // Build the payload
  const fileData = new FormData();
  fileData.append("file", element);

  // Theoretically, event listeners could be set after the open() call
  // but browsers are buggy here
  xhr.open("POST", "/api/import", true);

  // Note that the event listener must be set before sending (as it is a preflighted request)
  xhr.send(fileData);
}

</script>
<style type="text/css">
  body {
  background-color: lightblue;
}

main {
  margin: 50px auto;
  text-align: center;
}

#file {
  display: none;
}

label[for="file"] {
  background-color: lightgrey;
  padding: 10px 10px;
}

progress {
  display: none;
}

progress.visible {
  display: inline;
}

</style>