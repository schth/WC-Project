# -*- Coding: utf-8 -*-
from function import open_serial_port
from function import send_wc_status
from function import convert_comp_status
from function import is_status_changed
from function import get_sensor_list
import pprint

def main():
    '''シリアルポートを接続'''
    serial_connection = open_serial_port()
    '''
    センサー（個室）の状態をNで初期化
    comp_statusはdictionary型。key(キー)とvalue(値)のセット(要素)になっている
    例：Key：10e27d0、value:N
    comp_status = {'10e27d0': 'N', '10e3533': 'N', '10e29b1': 'N', '10e34ee': 'N'}
    '''
    comp_status = get_sensor_list()

    while 1:
        # 1行読み取る
        data = serial_connection.readline()
        # print(data)
        # 「;」で分割する
        m = str(data).split(';')
        if len(m) == 13:
            print('送信元シリアル番号：' + m[5] + ' / 送信元電源電圧：' + m[6] + ' / センサー電流：' + m[9])
            # 送信元のシリアルIDを取得
            sensor_id = m[5]
            if sensor_id in comp_status.keys():
                # センサーの値とバッテリーを取得
                current_sensor_value = int(m[9])
                current_sensor_battery = int(m[6])

                # センサーIDをKeyに、設置されている個室の直前の状態を取得
                before_comp_status = comp_status[sensor_id]
                # センサーの値から現在の個室の状態を割り出す
                current_comp_status = convert_comp_status(current_sensor_value)

                print('before_comp_status:' + comp_status[sensor_id] + '/'+ 'current_comp_status:' + current_comp_status)

                # 個室の状態に変化があった場合、データをAPIサーバーにPOSTして、DBを更新する
                if is_status_changed(before_comp_status, current_comp_status):
                    # POSTするデータは、センサーID、個室利用可否状況、センサーのバッテリー
                    wc_status = {'g_id': sensor_id, 'g_status': current_comp_status,
                                 'g_battery': current_sensor_battery}
                    # 個室の状態をAPIサーバーPOSTする
                    send_wc_status(wc_status)
                    # 個室の直前の状態を現在の状態に更新する
                    comp_status[sensor_id] = current_comp_status
                    print('before_comp_status(changed to):' + comp_status[sensor_id])

if __name__ == '__main__':
    try:
        main()
    except Exception as e:
        print('[ERROR OCCURRED]:',e)
