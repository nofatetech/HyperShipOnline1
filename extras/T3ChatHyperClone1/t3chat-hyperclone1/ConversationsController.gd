extends Node2D

@onready var conversation_scene: Node = $ConversationScene

func _ready():
	load_conversation()

func load_conversation():
	var sample_json := {
	"id": "root",
	"text": "Hello, how can I help you?",
	"children": [
		{
			"id": "1",
			"text": "I need help with my order.",
			"children": [
				{
					"id": "1.1",
					"text": "What’s your order number?",
					"children": [
						{
							"id": "1.1.1",
							"text": "It's 12345.",
							"children": [
								{
									"id": "1.1.1.1",
									"text": "Thanks, I found it. It’s on the way.",
									"children": []
								}
							]
						},
						{
							"id": "1.1.2",
							"text": "I don’t remember.",
							"children": [
								{
									"id": "1.1.2.1",
									"text": "Please check your email confirmation.",
									"children": []
								}
							]
						}
					]
				},
				{
					"id": "1.2",
					"text": "Please contact support.",
					"children": [
						{
							"id": "1.2.1",
							"text": "Okay, where can I reach them?",
							"children": [
								{
									"id": "1.2.1.1",
									"text": "support@example.com or 1-800-555-HELP",
									"children": []
								}
							]
						}
					]
				}
			]
		},
		{
			"id": "2",
			"text": "Nevermind.",
			"children": [
				{
					"id": "2.1",
					"text": "Okay, feel free to come back anytime.",
					"children": []
				},
				{
					"id": "2.2",
					"text": "Would you like to leave feedback instead?",
					"children": [
						{
							"id": "2.2.1",
							"text": "Sure.",
							"children": [
								{
									"id": "2.2.1.1",
									"text": "Thanks! Please rate us from 1 to 5.",
									"children": []
								}
							]
						},
						{
							"id": "2.2.2",
							"text": "No thanks.",
							"children": []
						}
					]
				}
			]
		}
	]
}


	conversation_scene.load_conversation_tree(sample_json)
