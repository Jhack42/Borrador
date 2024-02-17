from flask import Flask, request, render_template

app = Flask(__name__)

@app.route('/', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        nombre = request.form['nombre']
        edad = int(request.form['edad'])
        return render_template('saludo.html', nombre=nombre, edad=edad)
    else:
        return render_template('formulario.html')

if __name__ == '__main__':
    app.run(debug=True)
