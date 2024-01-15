import cv2
from pyzbar.pyzbar import decode

from picamera2 import MappedArray, Picamera2, Preview
from libcamera import controls
from libcamera import Transform
import numpy as np
import requests

# Rest of your code...

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
        
