<div class="mb-3">
    <label class="custom-upload" onclick="openCamera()">
        <div id="uploadText">Klik area ini untuk membuka kamera</div>
        <video id="video" autoplay></video>
        <canvas id="canvas" style="display: none;"></canvas>
        <img id="previewImage" />
    </label>
    <input type="hidden" name="{{ $nameInput }}" id="fotoInput">
</div>
