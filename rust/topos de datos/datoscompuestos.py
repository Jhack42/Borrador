#datos compuestos son datos son que adentro 
lista = ["Lucas Dalto","Soy Dalto",True,1.85] 
print(lista)
print(lista[0])
print(lista[1])
print(lista[2])
print(lista[3])

#duplas los datos nunca se ban a poder modificar 
tupla = ("Lucas Dalto","Soy Dalto",True,1.85)

print(tupla)
print(tupla[0])
print(tupla[1])
print(tupla[2])
print(tupla[3])

#ejemplo
#tupla[3] = "Maquinola"

print(tupla[3])
print(tupla)
#creando un conjunto (set) en un conjunto no se puede aber datos duplicados
conjunto = {"Lucas Dalto","Soy Dalto",True,1.85}

#print(conjunto[3]) -> no se puede acceder al elemento

conjunto = {"jaja maquina te jodi"}

print(conjunto)

#creando un siccionario (dict) (la estructura es key : value y separamoscon comas)
diccionario = {
    'nombre' : "Lucas Dalto",
    'canal': "Soy Dalto",
    'esta_emocionado' : True,
    'altura' : 1.84,
    'dato_duplicado' : "Soy Dalto"
}

print(diccionario['nombre'])