# coding: UTF-8
# pySerialのInstallが必要
import serial
import datetime
import urllib
import urllib.request
# requestsのInstallが必要
import requests
import json

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
# comp_statusはdictionary型。key(キー)とvalue(値)のセット(要素)になっている
# 例：Key：10e27d0、value:N
comp_status = {'10e27d0': 'N', '10e3533': 'N', '10e29b1': 'N', '10e34ee': 'N'}

# POST先
post_url = 'http://127.0.0.1/api/compartment/insert_status.php'

# APIサーバーにデータをPOSTする
def send_wc_status(wc_status):
    payload = wc_status
    response = requests.post(post_url, data = payload)
    print(response.text)

# センサーの値からドアの状態を変換する
def convert_comp_status(current_sensor_value):
    if current_sensor_value < sensor_threhold_value:
        # ドアが空いている
        return 'Y'
    # センサーの値が閾値を超えたら
    elif current_sensor_value > sensor_threhold_value:
        # ドアが空いていない
        return 'N'

# ドアの状態に変化があるかを判断
def is_status_changed(before_comp_status, current_comp_status):
    if before_comp_status != current_comp_status:
        return True
    elif before_comp_status == current_comp_status:
        return False

def get_sensor_list():
    # GET先
    get_url = 'http://127.0.0.1/api/compartment/get_sensor_list.php'
    # 読み込むオブジェクトの作成
    read_object = urllib.urlopen(get_url)
    # webAPIからのJSONを取得
    response = read_object.read()
    # print type(response)  # >> <type 'str'>
    # return response
    # webAPIから取得したJSONデータをpythonで使える形(辞書型)に変換する
    sensor_list = json.loads(response)
    return sensor_list

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
            # センサーの値とバッテリーを取得
            current_sensor_value = int(m[9])
            current_sensor_battery = int(m[6])

            # センサーIDをKeyに、設置されている個室の直前の状態を取得
            before_comp_status = comp_status[sensor_id]
            print("before_comp_status:" + comp_status[sensor_id])

            # センサーの値から現在の個室の状態を割り出す
            current_comp_status = convert_comp_status(current_sensor_value)
            print("current_comp_status:" + current_comp_status)

            # 個室の状態に変化があった場合、データをAPIサーバーにPOSTして、DBを更新する
            if is_status_changed(before_comp_status, current_comp_status) == True:
                # POSTするデータは、センサーID、個室利用可否状況、センサーのバッテリー
                wc_status = {'g_id': sensor_id,'g_status': current_comp_status,
                             'g_battery': current_sensor_battery}
                # 個室の状態をAPIサーバーPOSTする
                send_wc_status(wc_status)
                # 個室の直前の状態を現在の状態に更新する
                comp_status[sensor_id] = current_comp_status
                print("before_comp_status(changed to):" + comp_status[sensor_id])

s.close()
