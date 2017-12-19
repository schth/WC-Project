# coding: UTF-8
# pySerialのInstallが必要
import serial
import datetime
import urllib
import urllib.request
# requestsのInstallが必要
import requests

try:
    # COM5を開く windows用
    s = serial.Serial("COM5", 115200)

    # Mac用
    #s = serial.Serial("/dev/tty.usbserial-MW1IQ8BN", 115200)
    s.isOpen()
    print ("Port is opened!")
except IOError:
    s.close()
    s.open()
    print("Port was already open, was closed and opened again!")

# センサーの閾値
sensor_threhold_value = 1000

room1_device_id = "10e27d0"
room1_current_status = False#個室が利用できるかどうか
room1_before_status = False#以前の状態を記録

room2_device_id = "10e3533"
room2_current_status = False
room2_before_status = False

room3_device_id = ""
room3_current_status = False
room3_before_status = False

room4_device_id = ""
room4_current_status = False
room4_before_status = False

def send_wc_status(wc_status):
    requests.post('http://localhost/api/compartment/insert_status.php', data=wc_status)

def get_current_status(current_sensor_value):
    if current_sensor_value < sensor_threhold_value:
        #ドアが空いている
        return True
    elif current_sensor_value > sensor_threhold_value:
        #ドアが空いていない
        return False

def is_status_changed(current_sensor_status):
    if room_before_status != current_sensor_status:
        return True
    elif room_before_status == current_sensor_status:
        return False

while 1:
    # 1行読み取る
    data = s.readline()
    #print(data)
    # 「;」で分割する
    m = str(data).split(";")
    if (len(m) == 13):
        if m[5] == "10e27d0":
            sensor_id = "10e27d0"
            current_sensor_value = int(m[9])
            current_sensor_status = get_current_status(current_sensor_value)

            if is_status_changed(current_sensor_status) == True:
                comp_id = 1  
                # ドアが空いている場合、statusをYに設定
                status = 'Y'
                wc_status = {'g_id': comp_id, 'g_status': status}
                send_wc_status
            room1_before_status = room1_current_status

            if current_sensor_value < sensor_threhold_value:#ドアが空いている場合
                room1_current_status = True
                if room1_before_status != room1_current_status:
                    timestamp = datetime.datetime.now().strftime("%Y/%m/%d %I:%M:%S ")
                    print(timestamp + " " + m[5] + ": is opened !")
                    # 取得した値を変数に格納
                    comp_id = 1  # ここをusbから取得した値にしたい
                    # ドアが空いている場合、statusをYに設定
                    status = 'Y'  # ここをusbから取得した値にしたい
                    wc_status = {'g_id': comp_id, 'g_status': status}
                    # httpプロトコルでpost通信
                    response = requests.post('http://localhost/api/compartment/insert_status.php', data=wc_status)
                    #レスポンスのHTMLを文字列で取得
                    print(response.text)
                    room1_before_status = room1_current_status

            elif current_sensor_value > sensor_threhold_value:#ドアが閉じている場合（個室が利用されている）
                room1_current_status = False
                if room1_before_status != room1_current_status:
                    timestamp = datetime.datetime.now().strftime("%Y/%m/%d %I:%M:%S")
                    print(timestamp + " " + m[5] + ": is closed !")
                    # 取得した値を変数に格納
                    comp_id = 1  # ここをusbから取得した値にしたい
                    status = 'N'  # ここをusbから取得した値にしたい
                    wc_status = {'g_id': comp_id, 'g_status': status}
                    # httpプロトコルでpost通信
                    response = requests.post('http://localhost/api/compartment/insert_status.php', data=wc_status)
                    #レスポンスのHTMLを文字列で取得
                    print(response.text)
                    room1_before_status = room1_current_status
        #print ("送信元シリアル番号："+m[5]+" / 送信元電源電圧："+m[6]+" / センサー電流："+m[9])

        if m[5] == "10e27d0":
            current_sensor_value = int(m[9])
            #センサーの値を閾値と比較
            if current_sensor_value < sensor_threhold_value:#ドアが空いている場合
                room1_current_status = True
                if room1_before_status != room1_current_status:
                    timestamp = datetime.datetime.now().strftime("%Y/%m/%d %I:%M:%S ")
                    print(timestamp + " " + m[5] + ": is opened !")
                    # 取得した値を変数に格納
                    comp_id = 1  # ここをusbから取得した値にしたい
                    # ドアが空いている場合、statusをYに設定
                    status = 'Y'  # ここをusbから取得した値にしたい
                    wc_status = {'g_id': comp_id, 'g_status': status}
                    # httpプロトコルでpost通信
                    response = requests.post('http://localhost/api/compartment/insert_status.php', data=wc_status)
                    #レスポンスのHTMLを文字列で取得
                    print(response.text)
                    room1_before_status = room1_current_status

            elif current_sensor_value > sensor_threhold_value:#ドアが閉じている場合（個室が利用されている）
                room1_current_status = False
                if room1_before_status != room1_current_status:
                    timestamp = datetime.datetime.now().strftime("%Y/%m/%d %I:%M:%S")
                    print(timestamp + " " + m[5] + ": is closed !")
                    # 取得した値を変数に格納
                    comp_id = 1  # ここをusbから取得した値にしたい
                    status = 'N'  # ここをusbから取得した値にしたい
                    wc_status = {'g_id': comp_id, 'g_status': status}
                    # httpプロトコルでpost通信
                    response = requests.post('http://localhost/api/compartment/insert_status.php', data=wc_status)
                    #レスポンスのHTMLを文字列で取得
                    print(response.text)
                    room1_before_status = room1_current_status
                #print ("送信元シリアル番号："+m[5]+" / 送信元電源電圧："+m[6]+" / センサー電流："+m[9])

s.close()
