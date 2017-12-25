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
    #s = serial.Serial("COM5", 115200)

    # Mac用
    s = serial.Serial("/dev/tty.usbserial-MW1IQ8BN", 115200)
    s.isOpen()
    print("Port is opened!")
except IOError:
    s.close()
    s.open()
    print("Port was already open, was closed and opened again!")

# センサーの閾値
sensor_threhold_value = 1000

# センサー（個室）の状態をNで初期化
comp_status = {'10e27d0': 'N', '10e3533': 'N', '10e29b1': 'N', '10e34ee': 'N'}

# APIサーバーにデータをPOSTする
def send_wc_status(wc_status):
    payload = wc_status
    response = requests.post(
        'http://localhost/api/compartment/insert_status.php', data=payload)
    print(response.text)

# センサーの値からドアの状態を判断
def convert_comp_status(current_sensor_value):
    if current_sensor_value < sensor_threhold_value:
        # ドアが空いている
        return 'Y'
    elif current_sensor_value > sensor_threhold_value:
        # ドアが空いていない
        return 'N'

# ドアの状態に変化があるかをを判断
def is_status_changed(before_comp_status, current_comp_status):
    if before_comp_status != current_comp_status:
        return True
    elif before_comp_status == current_comp_status:
        return False


while 1:
    # 1行読み取る
    data = s.readline()
    # print(data)
    # 「;」で分割する
    m = str(data).split(";")
    if (len(m) == 13):
        print("送信元シリアル番号：" + m[5] + " / 送信元電源電圧：" + m[6] + " / センサー電流：" + m[9])
        # 送信元のシリアルIDを取得
        sensor_id = m[5]
        if sensor_id in comp_status:
            # センサーの値を取得
            current_sensor_value = int(m[9])
            # センサーのバッテリーを取得
            current_sensor_battery = int(m[6])
            # センサーが設置されている個室の直前の状態を取得
            before_comp_status = comp_status[sensor_id]
            # センサーの値から個室の状態を取得
            current_comp_status = convert_comp_status(current_sensor_value)
            print("before_comp_status:" + comp_status[sensor_id])
            # 個室の状態に変化があった場合
            if is_status_changed(before_comp_status, current_comp_status) == True:
                wc_status = {'g_id': sensor_id,'g_status': current_comp_status,
                             'g_battery': current_sensor_battery}
                # 個室の状態をAPIサーバーPOSTする
                send_wc_status(wc_status)
                # 個室の直前の状態を現在の状態に更新する
                comp_status[sensor_id] = current_comp_status
                print("before_comp_status(changed to):" + comp_status[sensor_id])

s.close()
