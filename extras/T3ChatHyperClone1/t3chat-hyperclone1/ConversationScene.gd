extends Node2D

@export var message_scene: PackedScene  # A reusable scene for displaying a message node (e.g. a Label with a bubble)

@onready var drawer := $ConnectionsDrawer


func load_conversation_tree(convo_json: Dictionary):
	_create_message_node(convo_json, position, 0)

func _create_message_node(data: Dictionary, pos: Vector2, depth: int) -> Node2D:
	var node = message_scene.instantiate()
	node.position = pos
	node.get_node("%MessageLabel").text = data["text"]
	add_child(node)

	var child_offset = Vector2(420, 300)
	var children = data.get("children", [])
	for i in range(children.size()):
		var child_data = children[i]
		var child_pos = pos + Vector2((i - children.size() / 2.0) * child_offset.x, child_offset.y)
		var child_node = _create_message_node(child_data, child_pos, depth + 1)

		# Register connection for drawing
		drawer.add_connection(node.position, child_node.position)

	return node
