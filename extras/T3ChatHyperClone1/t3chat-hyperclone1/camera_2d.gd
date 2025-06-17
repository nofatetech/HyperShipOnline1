extends Camera2D




var zoom_step := 0.1
var min_zoom := 0.5
var max_zoom := 3.0

func zoom_in():
	var new_zoom = zoom - Vector2(zoom_step, zoom_step)
	new_zoom.x = clamp(new_zoom.x, min_zoom, max_zoom)
	new_zoom.y = clamp(new_zoom.y, min_zoom, max_zoom)
	zoom = new_zoom

func zoom_out():
	var new_zoom = zoom + Vector2(zoom_step, zoom_step)
	new_zoom.x = clamp(new_zoom.x, min_zoom, max_zoom)
	new_zoom.y = clamp(new_zoom.y, min_zoom, max_zoom)
	zoom = new_zoom


var drag = false
var last_mouse_position = Vector2()




func _unhandled_input(event):
	if event is InputEventMouseButton:
		if event.button_index == MOUSE_BUTTON_LEFT:
			drag = event.pressed
			if drag:
				last_mouse_position = event.position

	elif event is InputEventMouseMotion and drag:
		var delta = event.position - last_mouse_position
		global_position -= delta
		last_mouse_position = event.position

func _input(event):
	if event is InputEventScreenTouch:
		drag = event.pressed
		if drag:
			last_mouse_position = event.position

	elif event is InputEventScreenDrag and drag:
		var delta = event.position - last_mouse_position
		global_position -= delta
		last_mouse_position = event.position


func _on_zoom_in_button_button_down() -> void:
	zoom_in()
	pass # Replace with function body.


func _on_zoom_out_button_button_down() -> void:
	zoom_out()
	pass # Replace with function body.
