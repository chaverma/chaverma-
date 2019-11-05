#coding:utf-8
print ("\n")
val = input('Enter your rating: ')
groupmates =[{"name": "Alan","group": "BAP-1851","age": 19,"marks": [2, 2, 2, 5, 4]},
 {"name": "Anna","group": "BAP-1851","age": 18,"marks": [3, 2, 3, 4, 3]},
 {"name": "Dmitry","group": "BAP-1851","age": 19,"marks": [3, 5, 4, 3, 5]},
 {"name": "Milena","group": "BAP-1851","age": 18,"marks": [5, 5, 5, 4, 5]}]
def print_students(students,val):
    undef=0;
    print ("Student Name".ljust(15),
        "Group".ljust(8),
        "Age".ljust(8),
        "assessment".ljust(20))
    for student in groupmates:
        for value in student["marks"]:
            undef = (value + undef)
        undef=round(undef/float(len(student["marks"])))
        if int(val) <= undef:
            print (student["name"].ljust(15),
                student["group"].ljust(8),
                str(student["age"]).ljust(8),
                str(student["marks"]).ljust(20))
        undef=0
print ("\n")
print_students(groupmates,val)
print ("\n")
