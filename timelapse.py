from picamera import PiCamera
import picamera
from time import sleep
import argparse
import random
import os

parser = argparse.ArgumentParser(description='Timelapse generator')
parser.add_argument('-d', type=int, nargs='?', default=5, help='delay between pictures in seconds')
parser.add_argument('-t', type=float, nargs='?', default=0.2, help='timelapse duration in minutes')
parser.add_argument('-f', type=str, nargs='?', help='folder where to store pictures')

args = parser.parse_args()

#intervallo in secondi tra un'immagine e la successiva
if (args.d>0):
    delay = args.d
else:
    delay =1

#durata in minuti della ripresa
time = args.t 

#cartella salvataggio immagini
path = '/home/pi/camera/'
if (args.f):
    os.makedirs(path + args.f)
    path = path + args.f + '/'
else:
    random.seed()
    folder = 'd' + str(random.randint(1,1000))
    while (os.path.exists(path + folder)):
               folder = 'd' + str(random.randint(1,1000))
    os.makedirs(path + folder)
    path = path + folder + '/'

#numero totale scatti
shots = int(time*60/delay)

print('parameters:')
print(delay)
print(time)
print(path)
print(shots)

camera = PiCamera()
camera.resolution = '720p'
camera.rotation = 180

try:
    for i in range(shots):
        camera.capture(path + 'imag{0:04d}.jpg'.format(i))
        sleep(delay)
finally:
    camera.stop()

print("done.")
