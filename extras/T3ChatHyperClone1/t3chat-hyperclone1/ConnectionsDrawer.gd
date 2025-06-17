extends Node2D

var lines: Array[Dictionary] = []

func add_connection(from_pos: Vector2, to_pos: Vector2):
	lines.append({ "from": from_pos, "to": to_pos })
	#update()

func _draw():
	for conn in lines:
		draw_line(conn.from, conn.to, Color.WHITE, 2)
