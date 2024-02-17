from flask import Flask, render_template
from datetime import datetime

app = Flask(__name__)

def obtener_hora_desde_sistema():
    try:
        current_time = datetime.now()
        formatted_time = current_time.strftime('%Y-%m-%d %H:%M:%S')  # Formatear la hora como una cadena
        return formatted_time
    except Exception as e:
        print("Error al obtener la hora desde el sistema:", e)
        return None

@app.route('/')
def index():
    current_time = obtener_hora_desde_sistema()
    return render_template('index.html', current_time=current_time)

if __name__ == "__main__":
    app.run(debug=True)
