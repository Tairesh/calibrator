#!/usr/bin/env python3

from telegram import ReplyKeyboardMarkup,ReplyKeyboardHide,InlineKeyboardMarkup,InlineKeyboardButton
from telegram.ext import Updater,CommandHandler,MessageHandler,Filters,CallbackQueryHandler
import sys
import logging
import json
from sqlobject import SQLObjectNotFound
import random

logging.basicConfig(format='%(asctime)s - %(name)s - %(levelname)s - %(message)s',level=logging.INFO)

updater = Updater(token='236596213:AAH6L4TzRkQ9ZyhRd3uOLXyPX3TITlXBiLQ')

SESSION = {}

def check_session_data(userId):
	if not userId in SESSION:
		SESSION[userId] = {}

def get_session_data(userId, name):
	check_session_data(userId)
	if name in SESSION[userId]:
		return SESSION[userId][name]
	else:
		return None

def set_session_data(userId, name, value):
	check_session_data(userId)
	SESSION[userId][name] = value

def clear_session_data(userId):
	SESSION[userId] = {}

def start(bot, update):
	bot.sendMessage(update.message.chat.id, 'Привет! Это бот для калибровки мозга')

def reply(bot, update):
	bot.sendMessage(update.message.chat.id, 'Тынц')

def button(bot, update):
	bot.sendMessage(update.message.chat.id, 'Тунц')

updater.dispatcher.add_handler(CommandHandler('start', start))
updater.dispatcher.add_handler(MessageHandler([Filters.text], reply))
updater.dispatcher.add_handler(CallbackQueryHandler(button))

try:
	updater.start_polling()
except(KeyboardInterrupt):
	updater.stop()
	quit()