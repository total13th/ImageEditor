from flask import Flask, request
import cv2
import numpy as np

app = Flask(__name__)

@app.route('/blur', methods=['POST'])
def blurImage():
    file = request.files['image']
    npImg = np.frombuffer(file.read(), np.uint8)
    img = cv2.imdecode(npImg, cv2.IMREAD_COLOR)

    blurred_img = cv2.GaussianBlur(img, (15, 15), 0)

    width = request.form['width']
    height = request.form['height']

    #image resize if there are values
    if(width != "" and height != ""):
        resized_img = cv2.resize(blurred_img, (int(width), int(height)))
        _, buffer = cv2.imencode('.jpg', resized_img)
    else:
        _, buffer = cv2.imencode('.jpg', blurred_img)

    editedImage = buffer.tobytes()

    return editedImage, 200, {'Content-Type': 'image/jpeg'}

if __name__ == '__main__':
    app.run(debug=True)