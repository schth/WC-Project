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

# global
server_host = 'localhost'


# pyserialでシリアルポートを自動認識して接続する
def open_serial_port():
    """
    参考URL: pyserial公式ドキュメント
    [1]サイトトップ http://pythonhosted.org/pyserial/
    [2]API一覧 http://pythonhosted.org/pyserial/pyserial_api.html
    [3]イントロダクション http://pythonhosted.org/pyserial/shortintro.html
    """
    serial_connection = serial.Serial()
    serial_connection.baudrate = 115200
    ports = list_ports.comports()  # ポートデータを取得
    devices = []
    for info in ports:
        devices.append(info.device)  # ポートの名前を取得
    if len(devices) == 0:
        # シリアル通信できるデバイスが見つからなかった場合
        print('error: シリアル通信できるデバイスが見つかりません')
        sys.exit(0)
    elif len(devices) == 1:
        serial_connection.port = devices[0]  # ポートを指定
    else:
        for i in range(len(devices)):
            print("input " + str(i) + ":\topen " + devices[i])
            # 開くポートを指定する
        print("input number of target port\n>> ", end="")
        while 1:
            try:
                num = int(input())
                serial_connection.port = devices[num]  # ポートを指定
                break
            except Exception as e:
                print('index out of range')
    try:
        # ポートを開いてみる
        serial_connection.open()
        print('open usb port: ' + serial_connection.port)
        return serial_connection
    except IOError:  # if port is already opened, close it and open it again and print message
        serial_connection.close()
        serial_connection.open()
        print("port was already open, was closed and opened again!")
    except serial_connection.serialutil.SerialException as e:
        print("can't open" + serial_connection.port)
        sys.exit(0)


# APIサーバーにデータをPOSTする
def send_wc_status(wc_status):
    """

    :param wc_status:
    """

    # POST先
    api_url = 'http://' + server_host + '/api/compartment/insert_status.php'
    payload = wc_status

    try :
        response = requests.post(api_url, data=payload)
        print('server response　: ' + response.text)
    except requests.exceptions.ConnectionError:
        print('Server Connection Error')
        print('... record updated failed ...')


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


# DBからセンサーの最新状態を取得
def get_sensor_list():
    """

    :return:
    """
    # GET先
    api_url = 'http://' + server_host + '/api/compartment/get_sensor_list.php'
    print('connect to ' + api_url)

    while 1 :
        try :
            response = requests.get(api_url)
            dic_response = {d['sensor_id']: d['status']
                        for d in json.loads(response.text)['records']}
            return dic_response
            break
        except requests.exceptions.ConnectionError:
            print('Server Connection Error')
            print('... ready to restart')
            #get_sensor_list()
        except json.JSONDecodeError:
            print(response.text)
            print('JSONDecodeError:' + 'DBが起動していない可能性があります')
        except ConnectionRefusedError:
            print('Server Connection Refused Error')
            print('... ready to restart')
            #get_sensor_list()
        # pprint.pprint(dic_response.keys())
