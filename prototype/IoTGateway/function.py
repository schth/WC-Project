# -*- Coding: utf-8 -*-
# pySerialのInstallが必要
import serial
import datetime
# requestsのInstallが必要
import requests
import json
# pprintのInstallが必要
import pprint
from serial.tools import list_ports
import sys

'''pyserialでシリアルポートを自動認識して接続する'''
def open_serial_port():

    """
    参考URL: pyserial公式ドキュメント
    [1]サイトトップ http://pythonhosted.org/pyserial/
    [2]API一覧 http://pythonhosted.org/pyserial/pyserial_api.html
    [3]イントロダクション http://pythonhosted.org/pyserial/shortintro.html
    """
    # COM5を開く windows用
    serial_connection = serial.Serial()
    serial_connection.baudrate = 115200
    ports = list_ports.comports()	# ポートデータを取得
    devices = []
    for info in ports:
        devices.append(info.device)	# ポートの名前を取得
    if len(devices) == 0:
    # シリアル通信できるデバイスが見つからなかった場合
        print("error: device not found")
        sys.exit(0)
    elif len(devices) == 1:
        serial_connection.port = devices[0]	# ポートを指定
    else:
        for i in range(len(devices)):
            print("input " + str(i)+":\topen "+devices[i])
    # 開くポートを指定する
    print("input number of target port\n>> ",end="")
    num = int(input())
    serial_connection.port = devices[num]	# ポートを指定

    try:
        serial_connection.open()
        print("open " + serial_connection.port )
        return serial_connection
    except:
        print("can't open" + serial_connection.port )
        sys.exit(0)
        # Mac用
        # s = serial.Serial('/dev/tty.usbserial-MW1IQ8BN', 115200)


# APIサーバーにデータをPOSTする
def send_wc_status(wc_status):
    """

    :param wc_status:
    """
    # POST先
    api_url = 'http://localhost/api/compartment/insert_status.php'
    payload = wc_status
    response = requests.post(api_url, data=payload)
    pprint.pprint(response.text)


# センサーの値からドアの状態を変換する
def convert_comp_status(current_sensor_value):
    """

    :param current_sensor_value:
    :return:
    """
    sensor_threhold_value = 1000
    if current_sensor_value < sensor_threhold_value:
        # ドアが空いている
        return 'Y'
    # センサーの値が閾値を超えたら
    elif current_sensor_value > sensor_threhold_value:
        # ドアが空いていない
        return 'N'


# ドアの状態に変化があるかを判断
def is_status_changed(before_comp_status, current_comp_status):
    """

    :param before_comp_status:
    :param current_comp_status:
    :return:
    """
    if before_comp_status != current_comp_status:
        return True
    elif before_comp_status == current_comp_status:
        return False


def get_sensor_list():
    """

    :return:
    """
    # GET先
    api_url = 'http://localhost/api/compartment/get_sensor_list.php'
    response = requests.get(api_url)
    dic_response = {d['sensor_id']: d['status'] for d in json.loads(response.text)['records']}
    pprint.pprint(dic_response.keys())
    return dic_response
