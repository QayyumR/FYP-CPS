########################################################### Import libraries
from socket import *
from time import ctime
import RPi.GPIO as gpio
import time
import threading

import serial
import os
import sys
import string
from subprocess import Popen

import pyrebase

gpio.setmode(gpio.BCM)


########################################################### Constant values

PWM_MAX = 100

########################################################### Disable warning from GPIO

gpio.setwarnings(False)

########################################################### Configure DIR Pins

leftMotor_DIR_pin = 27
gpio.setup(leftMotor_DIR_pin, gpio.OUT)

rightMotor_DIR_pin = 22
gpio.setup(rightMotor_DIR_pin, gpio.OUT)

gpio.output(leftMotor_DIR_pin, False)
gpio.output(rightMotor_DIR_pin, False)


########################################################### Configure PWM Pins

leftMotor_PWM_pin = 18
rightMotor_PWM_pin = 17

gpio.setup(leftMotor_PWM_pin, gpio.OUT)
gpio.setup(rightMotor_PWM_pin, gpio.OUT)


########################################################### Configure left and right motors spinning speed


# MAX Frequency 20 Hz
leftMotorPWM = gpio.PWM(leftMotor_PWM_pin,20)
rightMotorPWM = gpio.PWM(rightMotor_PWM_pin,20)


########################################################### Motor Initials


leftMotorPWM.start(0)
leftMotorPWM.ChangeDutyCycle(0)

rightMotorPWM.start(0)
rightMotorPWM.ChangeDutyCycle(0)



########################################################### Initialize


leftMotorPower = 0
rightMotorPower = 0



def getMotorPowers():
	
	return (leftMotorPower,rightMotorPower)		



########################################################### Left Motor Power

def setMotorLeft(power):

	if power < 0:
		# Reverse mode for the left motor
		gpio.output(leftMotor_DIR_pin, False)
		pwm = -int(PWM_MAX * power)
		if pwm > PWM_MAX:
			pwm = PWM_MAX
	elif power > 0:
		# Forward mode for the left motor
		gpio.output(leftMotor_DIR_pin, True)
		pwm = int(PWM_MAX * power)
		if pwm > PWM_MAX:
			pwm = PWM_MAX
	else:
		# Stopp mode for the left motor
		gpio.output(leftMotor_DIR_pin, False)
		pwm = 0

#	print "SetMotorLeft", pwm

	leftMotorPower = pwm
	leftMotorPWM.ChangeDutyCycle(pwm)




########################################################### Left Motor Power


def setMotorRight(power):

	if power < 0:
		# Reverse mode for the right motor
		gpio.output(rightMotor_DIR_pin, True)
		pwm = -int(PWM_MAX * power)
		if pwm > PWM_MAX:
			pwm = PWM_MAX
	elif power > 0:
		# Forward mode for the right motor
		gpio.output(rightMotor_DIR_pin, False)
		pwm = int(PWM_MAX * power)
		if pwm > PWM_MAX:
			pwm = PWM_MAX
	else:
		# Stopp mode for the right motor
		gpio.output(rightMotor_DIR_pin, False)
		pwm = 0


#	print "SetMotorRight", pwm


	rightMotorPower = pwm
	rightMotorPWM.ChangeDutyCycle(pwm)


########################################################### Terminate Program

def exit():

	gpio.output(leftMotor_DIR_pin, False)
	gpio.output(rightMotor_DIR_pin, False)

	gpio.cleanup()



########################################################### Turning for Auto Control
	
def stright():
    
    setMotorRight(-0.4)
    setMotorLeft(0.4)
	
	
def turnRight():
    
    setMotorRight(-0.1)
    setMotorLeft(0.6)
    
    
def turnLeft():
    
    setMotorRight(-0.6)
    setMotorLeft(0.1)


def stopMotor():
    
    setMotorRight(0)
    setMotorLeft(0)
    

########################################################### Turning for Manual Control
	
def forwardM():
    
    setMotorRight(-0.7)
    setMotorLeft(0.7)
	

def rightM():
    
    setMotorRight(0)
    setMotorLeft(0.6)
    

def leftM():
    
    setMotorRight(-0.6)
    setMotorLeft(0)


def reverseM():
    
    setMotorRight(0.7)
    setMotorLeft(-0.7)


def stopMotorM():
    
    setMotorRight(0)
    setMotorLeft(0)


########################################################### Auto Movement Method (Configure IR & Ultrasonic Sensor Pins)

def autoStart():

    rightSensor = 16
    leftSensor = 25

    gpio.setup(rightSensor, gpio.IN)
    gpio.setup(leftSensor, gpio.IN)

    TriggerLeft = 19
    EchoLeft = 26

    gpio.setup(TriggerLeft, gpio.OUT)
    gpio.setup(EchoLeft, gpio.IN)

    gpio.output(TriggerLeft, False)

    TriggerRight = 6
    EchoRight = 13

    gpio.setup(TriggerRight, gpio.OUT)
    gpio.setup(EchoRight, gpio.IN)

    gpio.output(TriggerRight, False)

    t = threading.currentThread()

    while getattr(t, "stopAuto", True):

        time.sleep(0.05)

        gpio.output(TriggerLeft, True)
        time.sleep(0.00001)
        gpio.output(TriggerLeft, False)

        while gpio.input(EchoLeft) == 0:
            pulse_start_left = time.time()

        while gpio.input(EchoLeft) == 1:
            pulse_end_left = time.time()

        pulse_duration_left = pulse_end_left - pulse_start_left
        distance_left = pulse_duration_left * 17150
        distance_left = round(distance_left, 2)

        gpio.output(TriggerRight, True)
        time.sleep(0.00001)
        gpio.output(TriggerRight, False)

        while gpio.input(EchoRight) == 0:
            pulse_start_right = time.time()

        while gpio.input(EchoRight) == 1:
            pulse_end_right = time.time()

        pulse_duration_right = pulse_end_right - pulse_start_right
        distance_right = pulse_duration_right * 17150
        distance_right = round(distance_right, 2)

        if distance_left >= 30 and distance_right >= 30:

            if gpio.input(rightSensor) == 0 and gpio.input(leftSensor) == 0:
                stright()

            if gpio.input(rightSensor) == 1 and gpio.input(leftSensor) == 0:
                turnRight()

            if gpio.input(rightSensor) == 0 and gpio.input(leftSensor) == 1:
                turnLeft()

            if gpio.input(rightSensor) == 1 and gpio.input(leftSensor) == 1:
                stopMotor()

        else:

            stopMotor()


########################################################### Configure RFID serial connection

ser = serial.Serial(

    port='/dev/ttyUSB0',
    baudrate=38400,
    parity=serial.PARITY_NONE,
    stopbits=serial.STOPBITS_ONE,
    bytesize=serial.EIGHTBITS,
    timeout=1
)

########################################################### Firebase Credentials

config = {
    
    "apiKey": "AIzaSyCxofI8Z_J0dJaESXsyzUUORWf1Qp3EdUQ",
    "authDomain": "cps-dragonfly.firebaseapp.com",
    "databaseURL": "https://cps-dragonfly-default-rtdb.asia-southeast1.firebasedatabase.app",
    "storageBucket": "cps-system-firebase.appspot.com"
}

firebase = pyrebase.initialize_app(config)
db = firebase.database()

########################################################### RFID scanning method

def rfidStart():

    tr = threading.currentThread()
    while getattr(tr, "stopRfid", True):

        ser.write(b'U\r')
        x = ser.read(ser.inWaiting())
        
        
        tags = x.decode("utf-8").strip().split()
        tags = tags[:-1]
        
        for tag in tags:
            
            data = {"rfid": tag[5: -4]}
            db.child("RoadRunner").child(tag[5: -4]).set(data)    
            print(tag[5: -4])

        time.sleep(2)

########################################################### App Commands


ctrCmd = ['Forward','Reverse','Left','Right','Stop','AutoOn','AutoOff','RfidOn', 'RfidOff']


########################################################### Connection to app

HOST = ''
PORT = 21567
BUFSIZE = 1024
ADDR = (HOST,PORT)

tcpSerSock = socket(AF_INET, SOCK_STREAM)
tcpSerSock.bind(ADDR)
tcpSerSock.listen(5)


########################################################### Main Program

checkAuto = False
checkRfid = False

while True:

        print ('Waiting for connection')
        tcpCliSock,addr = tcpSerSock.accept()
        print ('Connected from :', addr)

        try:
            while True:
                    data = ''
                    data = tcpCliSock.recv(BUFSIZE).decode()
                    data = data[2:]
                    
                    
                    if not data:
                        break

                    if data == ctrCmd[0]:
                        forwardM()
                        print ('Forward')

                    if data == ctrCmd[1]:
                        reverseM()
                        print ('Reverse')

                    if data == ctrCmd[2]:     
                        leftM()
                        print ('Left')

                    if data == ctrCmd[3]:          
                        rightM()
                        print ('Right')

                    if data == ctrCmd[4]:         
                        stopMotorM()
                        print ('Stop')

                    if data == ctrCmd[5]:
                        if checkAuto == False:
                            t = threading.Thread(target=autoStart)
                            t.start()
                            checkAuto = True
                        print ('Auto On')

                    if data == ctrCmd[6]:
                        if checkAuto == True:
                            t.stopAuto = False
                            checkAuto = False
                            time.sleep(0.3)
                            stopMotorM()
                        print ('Auto Off')
                    
                    if data == ctrCmd[7]:
                        if checkRfid == False:
                            tr = threading.Thread(target=rfidStart)
                            tr.start()
                            checkRfid = True
                        print('Rifd On')

                    if data == ctrCmd[8]:
                        if checkRfid == True:
                            tr.stopRfid = False
                            checkRfid = False
                        print('Rfid Off')
                    

        except KeyboardInterrupt:
                exit()


tcpSerSock.close();

########################################################### End
