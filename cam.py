import cv2
from pyzbar.pyzbar import decode
from picamera2 import MappedArray, Picamera2, Preview
from libcamera import controls
from libcamera import Transform
from libcamera import Orientation

import numpy as np
import requests
from flask import Flask, render_template, Response, stream_with_context, request

video = cv2.VideoCapture(0)
app = Flask('__name__')

url = "http://192.168.242.152:8000/api/process-qr-code"

key = "data"

colour = (0, 255, 0)
font = cv2.FONT_HERSHEY_SIMPLEX
scale = 1
thickness = 2

def draw_barcodes(request):
    with MappedArray(request, "main") as m:
        for b in barcodes:
            if b.polygon:
                x = min([p.x for p in b.polygon])
                y = min([p.y for p in b.polygon]) - 30
                cv2.putText(m.array, b.data.decode('utf-8'), (x, y), font, scale, colour, thickness)

def post_qr_code_data():
    for b in barcodes:
        if b.polygon:
            data = b.data.decode('utf-8')
            response = requests.post(url, json={key: data})
            print(f"Posted data: {data}, Server response: {response.json()}")
            
def video_stream():
    while True:
        ret, frame = video.read()
        if not ret:
            break;
        else:
            ret, buffer = cv2.imencode('.jpeg',frame)
            frame = buffer.tobytes()
            yield (b' --frame\r\n' b'Content-type: imgae/jpeg\r\n\r\n' + frame +b'\r\n')
            
@app.route('/cam')
def camera():
    return render_template('cam.html')


@app.route('/video_feed')
def video_feed():
    return Response(video_stream(), mimetype='multipart/x-mixed-replace; boundary=frame')


app.run(host='0.0.0.0', port='5000', debug=False)

picam2 = Picamera2()
picam2.start_preview(Preview.QTGL)
config = picam2.create_preview_configuration(main={"size": (640, 480)}, transform=Transform(hflip=True, vflip=True))
picam2.configure(config)


barcodes = []
picam2.post_callback = draw_barcodes
picam2.start()

while True:
    rgb = picam2.capture_array("main")
    barcodes = decode(rgb)
    
    if barcodes:
        print(barcodes)
    
    if barcodes:
        post_qr_code_data()
    
